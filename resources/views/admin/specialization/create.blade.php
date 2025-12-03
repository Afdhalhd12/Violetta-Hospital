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
        <form method="POST" action="{{ route('admin.specialization.store') }}" class="border card rounded p-5">
            <h5 class="text-center">Create Specialization Data</h5>
            @csrf
            <div class="mb-3">
                <label for="specialist" class="form-label">Specialization</label>
                <input type="text" name="specialist" id="specialist" class="form-control" value="{{ old('specialist') }}">
                @error('specialist')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
               <label for="description" class="form-label">description</label>
                <textarea type="text" name="description" id="description" rows="5" class="form-control">{{old('description')}}</textarea>
                @error('description')
                <small class="text-danger">{{$message}}</small>
                @enderror
            </div>


            <button type="submit" class="btn btn-color">Submit</button>
        </form>
    </div>
@endsection
