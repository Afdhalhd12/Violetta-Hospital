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
        <form method="POST" action="{{ route('admin.specialization.update', $specialist->id) }}" class="border card rounded p-5" enctype="multipart/form-data">
            <h5 class="text-center">Edit Data Doctor</h5>
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="specialist" class="form-label">Spesialis</label>
                <input type="text" name="specialist" id="specialist" class="form-control" value="{{ $specialist->specialist }}">
                @error('specialist')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <input type="description" name="description" id="description" class="form-control" value="{{ $specialist->description }}">
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-color">Kirim Data</button>
        </form>
    </div>
@endsection
