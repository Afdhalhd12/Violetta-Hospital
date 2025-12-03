@extends('templates.nav')
@section('content')
    <form class="container mt-5" style="max-width: 800px;" method="POST"action="{{ route('login.auth') }}">
        @csrf

        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif

        @if (Session::get('error'))
            <div class="alert alert-danger w-100">{{ Session::get('error') }}</div>
        @endif

        <!-- Email input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" id="form2Example1" class="form-control" @error('email') is-invalid @enderror name="email" />
            <label class="form-label" for="form2Example1">Email address</label>
        </div>
        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror

        <!-- Password input -->
        <div data-mdb-input-init class="form-outline mb-4 mt-3">
            <input type="password" id="form2Example2" class="form-control" @error('password') is-invalid @enderror
                name="password" />
            <label class="form-label" for="form2Example2">Password</label>
        </div>
        @error('password')
            <small class="text-danger">{{ $message }}</small>
        @enderror



        <!-- Submit button -->
        <button data-mdb-ripple-init type="submit" class="btn btn-color btn-block mb-4 mt-3">Sign in</button>
        <div class="col d-flex justify-content-center">
            <!-- Simple link -->
            <a href="{{ route('signup') }}">Sign-up</a>
        </div>
    </form>
@endsection
