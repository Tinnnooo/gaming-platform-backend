@extends('AdministratorPortal.layouts.main')


@section('main')
    <main class="container d-flex  justify-content-center min-vh-100 align-items-center" >
        <form method="POST" action="{{ route('admin.login.submit') }}" class="border p-4 rounded border-primary">
            @csrf

            <div class="text-center mb-2">
                <h3 class="fw-bold text-primary ">Admin Login</h3>
            </div>

            @if (session()->has('loginError'))
                <div class="text-danger mt-2">
                    {{ session('loginError') }}
                </div>
            @endif


            <div class="mt-2">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" value="{{ old('username') }}" class="form-control" />
                @if ($errors->has('username'))
                    <p class="text-danger text-center">{{ $errors->first('username') }}</p>
                @endif
            </div>

            <div class="mt-2">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" class="form-control"/>
                @if ($errors->has('password'))
                    <p class="text-danger text-center">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-primary">Log in</button>
            </div>
        </form>
    </main>

@endsection
