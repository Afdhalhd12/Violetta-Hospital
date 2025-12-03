<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use App\Models\user;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\SpecializationExport;
use Maatwebsite\Excel\Facades\Excel;

class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specialization = Specialization::all();
        return view('admin.specialization.index', compact('specialization'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.specialization.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'specialist' => 'required|min:5',
            'description' => 'required|min:10',

        ],[
          'specialist.required' => 'Spesialis dokter harus diisi',
          'specialist.min' => 'Spesialis dokter harus diisi minimal 5 karakter',
          'description.required' => 'deskripsi spesialis harus diisi',
          'description.min' => 'Deskripsi spesialis dokter harus diisi minimal 10 karakter',
        ]);

        $createData = Specialization::create([
            'specialist' => $request->specialist,
            'description' => $request->description,
        ]);

        //menentukan perpindahan setelah data berhasil disimpan
        if ($createData) {
            //redirect() memindahkan halaman, route() : memanggil nama route, with() : mengirimkan session data, biasanya untuk notifikasi
            return redirect()->route('admin.specialization.index')->with('success', 'Data Berhasil di tambahkan');
        } else {
            //back() : kembali ke halaman sebelumnya, dengan membawa data session
            return redirect()->back()->with('error', 'Gagal menambahkan data, silahkan coba lagi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialization $specialization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $specialist = Specialization::find($id);
        return view('admin.specialization.edit', compact('specialist'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specialization $Specialization, $id)
    {
         $request->validate([
            'specialist' => 'required|min:5',
            'description' => 'required|min:10',

        ],[
          'specialist.min' => 'Spesialis dokter harus diisi minimal 5 karakter',
          'description.required' => 'deskripsi spesialis harus diisi',
          'description.min' => 'Deskripsi spesialis dokter harus diisi minimal 10 karakter',
        ]);

        $updateData = Specialization::where('id', $id)->update([
            'specialist' => $request->specialist,
            'description' => $request->description,
        ]);

        //menentukan perpindahan setelah data berhasil disimpan
        if ($updateData) {
            //redirect() memindahkan halaman, route() : memanggil nama route, with() : mengirimkan session data, biasanya untuk notifikasi
            return redirect()->route('admin.specialization.index')->with('ok', 'Data Berhasil di tambahkan');
        } else {
            //back() : kembali ke halaman sebelumnya, dengan membawa data session
            return redirect()->back()->with('error', 'Gagal menambahkan data, silahkan coba lagi');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $specialist = Specialization::find($id);
         $specialistExist = User::where('specialization_id', $specialist->id)->exists();
          if($specialistExist){
            return redirect()->back()->with('failed', 'Spesialist masih terdaftar');
        }

        $specialist->delete();
        if ($specialist) {
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->back()->with('failed', 'Gagal silahkan coba lagi');
        }
    }

    public function trash()
    {
        $specialists = Specialization::onlyTrashed()->get();
        return view('admin.specialization.trash', compact('specialists'));
    }

    public function restore($id)
    {
        $specialist = Specialization::onlyTrashed()->where('id', $id)->first();
        $specialist->restore();
        if ($specialist) {
            return redirect()->back()->with('success', 'Data berhasil dikembalikan');
        } else {
            return redirect()->back()->with('failed', 'Gagal silahkan coba lagi');
        }
    }

    public function deletePermanent($id)
    {
        $specialist = Specialization::onlyTrashed()->where('id', $id)->first();
        $specialist->forceDelete();
        if ($specialist) {
            return redirect()->back()->with('success', 'Data berhasil dihapus permanen');
        } else {
            return redirect()->back()->with('failed', 'Gagal silahkan coba lagi');
        }
    }

     public function export()
    {
        return Excel::download(new SpecializationExport, 'Specialization.xlsx');
    }
}
