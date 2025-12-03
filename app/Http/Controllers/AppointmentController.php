<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Exports\AppointmentExport;
use App\Exports\PatientExport;
use App\Models\appointment;
use App\Http\Controllers\Controller;
use App\Models\user;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil id dokter yg sedang login
        $doctorId = Auth::id();

        $appointments = Appointment::with(['patient', 'payment'])
            ->where('doctor_id', $doctorId)
            ->whereHas('payment', function($q){
                $q->where('payment_status', 'paid');
            })
            ->orderBy('date', 'asc')
            ->get();
        return view('dokter.dashboard.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('appointment.create', compact('doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'date'      => 'required|date|after:now',
            'time'      => 'required',
            'notes'     => 'nullable|string',
        ]);

        $doctor = User::FindOrFail($request->doctor_id);
        $doctorFee = $doctor->doctor_fee ?? 0;


        $appointment = Appointment::create([
            'user_id'        => Auth::id(),
            'doctor_id'      => $request->doctor_id,
            'date'           => $request->date,
            'time'           => $request->time,
            'notes'          => $request->notes,
            'status'         => 'pending',
            'doctor_fee'    => $doctorFee,
        ]);

        $payment = Payment::create([
        'appointment_id' => $appointment->id,
        'total_price'    => $doctorFee,
        'payment_status' => 'pending',
    ]);

        $invoiceId = 'INV-' . $appointment->id;
        $qrData = "INV-" . $invoiceId;


        $qrImage = QrCode::format('svg')->size(300)->margin(2)->generate($qrData);


        $fileName = 'APPT-' . $appointment->id . '.svg';
        $filePath = 'qrcodes/' . $fileName;


        Storage::disk('public')->put($filePath, $qrImage);

        $payment->invoice_id = $invoiceId;
        $payment->qr_path    = $filePath;
        $payment->save();


        return redirect()
            ->route('appointment.qr', $appointment->id)
            ->with('ok', 'Silakan lakukan pembayaran online melalui QR.');
    }
    /**
     * Display the specified resource.
     */
    public function show()
    {
        // Ambil id User yang sedang login
        $userId = Auth::id();

        $appointments = Appointment::with('doctor')
            ->whereHas('payment', function($q){
                $q->where('payment_status', 'paid');
            })
            ->where('user_id', $userId)
            ->orderBy('date', 'asc')
            ->get();
        return view('appointment.detail', compact('appointments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $Appointment, $id)
    {
        $request->validate([
            'status' => 'required',
            'response' => 'nullable|string',

        ], [
            'status.required' => 'Status harus diisi',
            'response.string' => 'Response harus berupa teks',
        ]);

        $updateData = Appointment::where('id', $id)->update([
            'status' => $request->status,
            'response' => $request->response,
        ]);

        //menentukan perpindahan setelah data berhasil disimpan
        if ($updateData) {
            //redirect() memindahkan halaman, route() : memanggil nama route, with() : mengirimkan session data, biasanya untuk notifikasi
            return redirect()->back()->with('success', 'Status pasien berhasil diperbarui');
        } else {
            //back() : kembali ke halaman sebelumnya, dengan membawa data session
            return redirect()->back()->with('error', 'Gagal memperbarui status pasien, silahkan coba lagi');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(appointment $appointment)
    {
        //
    }

    public function export()
    {
        return Excel::download(new AppointmentExport, 'Appointment_Patient.xlsx');
    }
    public function export_patient()
    {
        return Excel::download(new PatientExport, 'DoctorList.xlsx');
    }

    public function showQr(Appointment $appointment)
    {
        $payment = $appointment->payment;
       $qrData = $payment->invoice_id;

        return view('appointment.qr', [
            'appointment' => $appointment,
            'payment'     => $payment,
            'qrData'      => $qrData,
        ]);
    }


    public function confirmPayment(appointment $appointment)
    {
       $payment = $appointment->payment;

        if ($payment) {
            $payment->update([
                'payment_status' => 'paid',
            ]);
        }

        return redirect()->route('home')->with('success', 'Pembayaran berhasil! Janji temu telah dikonfirmasi.');
    }


public function exportPdf(Appointment $appointment)
{
    $payment = $appointment->payment;

    $pdf = Pdf::loadView('appointment.pdf', [
            'appointment' => $appointment,
            'payment'     => $payment,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('Bukti-Pembayaran-' . $payment->invoice_id . '.pdf');
}

public function chartData(){
    $paid = Payment::where('payment_status', 'paid')->count();
    $unpaid = Payment::where('payment_status', 'pending')->count();

    $labels = ['Paid', 'Unpaid'];
    $data = [$paid, $unpaid];

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
}

public function chartBySpecialization()
{
    // Ambil semua appointment paid + relasi doctor & specialization
    $appointments = Appointment::with(['doctor.specialization', 'payment'])
            ->whereHas('payment', function ($q) {
                $q->where('payment_status', 'paid');
            })
            ->get();

    // Kelompokkan berdasarkan nama spesialis
    $grouped = $appointments->groupBy(function ($appointment) {
        return optional($appointment->doctor->specialization)->specialist ?? 'Tidak ada spesialisasi';
    });

    $labels = $grouped->keys();                 // nama spesialis
    $data   = $grouped->map->count()->values(); // jumlah appointment per spesialis

    return response()->json([
        'labels' => $labels,
        'data'   => $data,
    ]);
}

public function payment(){
    $userId = Auth::id();
        $appointments = Appointment::with('doctor')
        ->whereHas('payment', function($q){
            $q->where('payment_status', 'pending');
        })
            ->where('user_id', $userId)
            ->orderBy('date', 'asc')
            ->get();
        return view('appointment.payment', compact('appointments'));
}

public function paymentDetail(Appointment $appointment){
    return redirect()->route('appointment.qr', $appointment->id);
}


}
