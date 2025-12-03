<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Specialization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function home()
    {
        $specializ = Specialization::all();


        $users = User::with('specialization')
            ->where('role', 'doctor')
            ->orderBy('created_at', 'DESC')
            ->limit(4)
            ->get();

        return view('home', compact('users', 'specializ'));
    }


    public function filterDoctor($id = null)
    {
        $specializ = Specialization::all();
        $query = User::with('specialization')->where('role', 'doctor');
        if ($id) {
            $query->where('specialization_id', $id);
        }
        $users = $query->orderBy('name', 'ASC')->get();
        return view('home', compact('users', 'specializ'));
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //untuk mengambil bagian doctor dan admin saja
        $specialization = Specialization::all();
        $users = User::with('specialization')->where('role', 'doctor')->get();
        return view('admin.doctor.index', compact('users', 'specialization'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|min:8',

        ], [
            'first_name.required' => 'Nama depan tidak boleh kosong',
            'first_name.min' => 'Nama harus diisi minimal 3 karakter',
            'last_name' => 'Nama belakang tidak boleh kosong',
            'last_name.min' => 'Nama belakang harus diisi minimal 3 karakter',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter'

        ]);

        $createUser = User::create([
            'name' => $request->first_name . " " . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            //role diisi langsung dengan user, agar tdk mengakses admin/dokter
            'role' => 'user',
        ]);

        //menentukan perpindahan setelah data berhasil disimpan
        if ($createUser) {
            //redirect() memindahkan halaman, route() : memanggil nama route, with() : mengirimkan session data, biasanya untuk notifikasi
            return redirect()->route('login')->with('ok', 'Akun berhasil dibuat, silahkan masuk');
        } else {
            //back() : kembali ke halaman sebelumnya, dengan membawa data session
            return redirect()->back()->with('error', 'Gagal membuat akun, silahkan coba lagi');
        }
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi'
        ]);

        //mengambil data yang akan di cek kecocokannya : email-pw  username-pw
        $data = $request->only(['email', 'password']);
        if (Auth::attempt($data)) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.doctor.index')->with('success', 'Login berhasil dilakukan');
            } else if (Auth::user()->role == 'doctor') {
                return redirect()->route('dokter.dashboard.index')->with('login', 'Login berhasil dilakukan');
            } else {
                return redirect()->route('home')->with('success', 'Login berhasil dilakukan!,');
            }
        }
        //Auth -> class authentication pada laravel yang menyimpan data session yang berhubungan dengan pengguna
        //attemp -> melakukan pengecekan data, jika sesuai maka data pengguna disimnpan pada session auth
        if (Auth::attempt($data)) {
            return redirect()->route('home')->with('success', 'Login berhasil dilakukan!');
        } else {
            return redirect()->back()->with('error', 'Gagal login! coba lagi');
        }
    }

    public function logout()
    {
        //menghapus sesi login
        Auth::logout();
        return redirect()->route('home')->with('logout', 'Berhasil logout');
    }

    public function create()
    {
        $specializations = Specialization::all();
        return view('admin.doctor.create', compact('specializations'));
    }

    public function storeDoctor(request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|min:8',
            'specialization_id' => 'required',
            'doctor_fee' => 'required|integer|min:0',
            'photo' => 'required|mimes:jpg,png,jpeg,webp,svg,',

        ], [
            'name.required' => 'Nama depan tidak boleh kosong',
            'name.min' => 'Nama harus diisi minimal 3 karakter',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'doctor_fee.required' => 'Biaya konsultasi harus diisi',
            'photo.required' => 'Photo dokter harus diisi',
            'photo.mimes' => 'Photo dokter harus berupa JPG/JPEG/PNG/SVG/WEBP',
            'specialization_id.required' => 'Spesialis dokter harus diisi',
        ]);

        //$request->file('name_input') : ambil file yang diperlukan
        $gambar = $request->file('photo');
        //buat nama baru, nama acak untuk membedakan tiap file, akan menjadi : abcde-photo.jpg
        //getClientOriginalExtension() : ambil extensi file
        $namaGambar = Str::random(5) . "-photo." . $gambar->getClientOriginalExtension();
        //StoreAs() => menyimpan file, format storeAs('namaFolder',' namafile', 'visibility)
        //hasil storeAs() berupa alamat file, visibility : public/private
        $path = $gambar->storeAs("photo", $namaGambar, "public");

        $createUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'specialization_id' => $request->specialization_id,
            'doctor_fee' => $request->doctor_fee,
            'photo' => $path,
            'role' => 'doctor',


        ]);

        //menentukan perpindahan setelah data berhasil disimpan
        if ($createUser) {
            //redirect() memindahkan halaman, route() : memanggil nama route, with() : mengirimkan session data, biasanya untuk notifikasi
            return redirect()->route('admin.doctor.index')->with('ok', 'Akun berhasil dibuat, silahkan masuk');
        } else {
            //back() : kembali ke halaman sebelumnya, dengan membawa data session
            return redirect()->back()->with('failed', 'Gagal membuat akun, silahkan coba lagi');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        $specializations = Specialization::all();
        return view('admin.doctor.edit', compact('user', 'specializations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|email:dns',
            'password' => 'nullable|min:8',
            'specialization_id' => 'required',
            'photo' => 'mimes:jpg,png,jpeg,webp,svg,',
            'doctor_fee' => 'required|integer|min:0',


        ], [
            'name.required' => 'Nama lengkap tidak boleh kosong',
            'name.min' => 'Nama lengkap harus diisi minimal 5 karakter',
            'email.required' => 'Email tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'email.email' => 'Format email tidak valid',
            'photo.required' => 'Photo dokter harus diisi',
            'photo.mimes' => 'Photo dokter harus berupa JPG/JPEG/PNG/SVG/WEBP',
            'specialization_id.required' => 'Spesialis dokter harus diisi',
            'doctor_fee.required' => 'Biaya konsultasi harus diisi'
        ]);

        $user = User::find($id);
        if ($request->file('photo')) {
            $fileSebelumnya = storage_path("app/public/" . $user['photo']);
            //file_exist() : cek apakah file nya ada di storage/app/public/photo/nama.jpg
            if (file_exists($fileSebelumnya)) {
                //unlink() : hapus
                unlink($fileSebelumnya);
            }
            //$request->file('name_input') : ambil file yang diperlukan
            $gambar = $request->file('photo');
            //buat nama baru, nama acak untuk membedakan tiap file, akan menjadi : abcde-photo.jpg
            //getClientOriginalExtension() : ambil extensi file
            $namaGambar = Str::random(5) . "-photo." . $gambar->getClientOriginalExtension();
            //StoreAs() => menyimpan file, format storeAs('namaFolder',' namafile', 'visibility)
            //hasil storeAs() berupa alamat file, visibility : public/private
            $path = $gambar->storeAs("photo", $namaGambar, "public");
        }

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'specialization_id' => $request->specialization_id,
            'doctor_fee' => $request->doctor_fee,
            'photo' => $path ?? $user['photo']
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $updateData = User::where('id', $id)->update($data);

        if ($updateData) {
            return redirect()->route('admin.doctor.index')->with('ok', 'Berhasil mengubah data');
        } else {
            return redirect()->back()->with('failed', 'Gagal mengubah data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id)->delete();
        if ($user) {
            return redirect()->back()->with('ok', 'Data berhasil dihapus');
        } else {
            return redirect()->back()->with('failed', 'Gagal silahkan coba lagi');
        }
    }

    public function trash()
    {
        $users = User::onlyTrashed()->get();
        return view('admin.doctor.trash', compact('users'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->first();
        $user->restore();
        if ($user) {
            return redirect()->back()->with('success', 'Data berhasil dikembalikan');
        } else {
            return redirect()->back()->with('failed', 'Gagal silahkan coba lagi');
        }
    }

    public function deletePermanent($id)
    {
        $user = User::onlyTrashed()->find($id);
        $fileSebelumnya = storage_path("app/public/" . $user['photo']);
        //file_exist() : cek apakah file nya ada di storage/app/public/poster/nama.jpg
        if (file_exists($fileSebelumnya)) {
            //unlink() : hapus
            unlink($fileSebelumnya);
        }
        // forceDelete() Menghapus selamanya
        $user->forceDelete();
        return redirect()->back()->with('success', 'Data berhasil dihapus selamanya');
    }

    public function export()
    {
        return Excel::download(new UserExport, 'users.xlsx');
    }
}
