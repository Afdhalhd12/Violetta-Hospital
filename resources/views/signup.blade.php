@extends('templates.nav')
@section('content')
    <form class="container mt-5" style="max-width: 800px;" method="POST" action="{{ route('signup.store') }}">
        @csrf
        <!-- 2 column grid layout with text inputs for the first and last names -->
        <div class="row mb-4">
            <div class="col">
                <div data-mdb-input-init class="form-outline">
                    <input type="text" name="first_name" id="form3Example1"
                        class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" />
                    <label class="form-label" for="form3Example1">First name</label>
                </div>
                @error('first_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col">
                <div data-mdb-input-init class="form-outline">
                    <input type="text" name="last_name" id="form3Example2"
                        class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" />
                    <label class="form-label" for="form3Example2">Last name</label>
                </div>
                @error('last_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <!-- Email input -->
        <div data-mdb-input-init class="form-outline mt-3">
            <input type="email" name="email" id="form3Example3"
            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" />
            <label class="form-label" for="form3Example3">Email address</label>
        </div>
        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror

        <!-- Password input -->
        <div data-mdb-input-init class="form-outline mt-3">
            <input type="password" name="password" id="form3Example4"
            class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" />
            <label class="form-label" for="form3Example4">Password</label>
        </div>
        @error('password')
            <small class="text-danger">{{ $message }}</small>
        @enderror

        <!-- Submit button -->
        <button data-mdb-ripple-init type="submit" class="btn btn-color btn-block mb-4 mx-auto mt-5"
            style="margin-top: 20px;">Sign up</button>
    </form>
@endsection
