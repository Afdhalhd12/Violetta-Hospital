@extends('templates.nav')
@section('content')
    <div class="w-75 d-block mx-auto mt-3 p-4">
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif
        <nav class="p-2 border mb-4"
            style="background: rgb(245, 245, 245); box-shadow: 0px, 0px, 0px, 2px, black; border-radius: 5px">
            <a href="#" style="color: gray">Pengguna</a>
            <small style="color: gray">/</small>
            <a href="{{ route('admin.doctor.index') }}" style="color: gray">Data</a>
            <small style="color: gray">/</small>
            <a href="#" style="color: gray">Edit</a>
        </nav>
        <form method="POST" action="{{ route('admin.doctor.update', $user->id) }}" class="border card rounded p-5"
            enctype="multipart/form-data">
            <h5 class="text-center">Edit Data Doctor</h5>
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label">Specialization</label>
                    <select name="specialization_id" class="form-select" required>
                        <option value="">-- Choose specialization --</option>
                        @foreach ($specializations as $spec)
                            <option value="{{ $spec->id }}" @if ($user->specialization_id == $spec->id) selected @endif>
                                {{ $spec->specialist }}
                            </option>
                        @endforeach
                    </select>
                    @error('specialization_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                <div class="col-6">
                    <label for="photo" class="form-label">Foto Dokter</label>
                    <img src="{{ asset('storage/' . $user['photo']) }}" width="120" class="d-block mx-auto">
                    <input type="file" name="photo" id="photo" class="form-control"
                        @error('photo') is-invalid @enderror>
                    @error('photo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>



            <div class="mb-3">
                <label for="doctor_fee" class="form-label">Doctor Fee</label>
                <input type="doctor_fee" name="doctor_fee" id="doctor_fee" class="form-control" value="{{ $user->doctor_fee }}">
                @error('doctor_fee')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-color">Kirim Data</button>
        </form>
    </div>
@endsection
