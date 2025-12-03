@extends('templates.nav')
@section('content')
    <div class="w-75 d-block mx-auto mt-3 p-4">
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif
        <nav class="p-2 border mb-4"
            style="background: rgb(245, 245, 245); box-shadow: 0px, 0px, 0px, 2px, black; border-radius: 5px">
            <a href="#" style="color: gray">User</a>
            <small style="color: gray">/</small>
            <a href="{{ route('admin.doctor.index') }}" style="color: gray">Data</a>
            <small style="color: gray">/</small>
            <a href="#" style="color: gray">Create</a>
        </nav>
        <form method="POST" action="{{ route('admin.doctor.store') }}" enctype="multipart/form-data"
            class="border card rounded p-5">
            <h5 class="text-center">Create a doctor account</h5>
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
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
                            <option value="{{ $spec->id }}" {{ old('specialization_id') == $spec->id ? 'selected' : '' }}>
                                {{ $spec->specialist }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="col-6">
                    <label for="photo" class="form-label">Doctor's photo</label>
                    <input type="file" name="photo" id="photo" class="form-control"
                        @error('photo') is-invalid @enderror>
                    @error('photo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="doctor_fee" class="form-label">Doctor Fee</label>
                <input type="number" name="doctor_fee" id="doctor_fee" class="form-control" value="{{ old('doctor_fee') }}">
                @error('doctor_fee')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-color">Submit</button>
        </form>
    </div>
@endsection
