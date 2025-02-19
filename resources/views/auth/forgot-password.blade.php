@extends('home-view.commun')

@section('content')

<style>
    body {
        background-color: #f8f9fa;
    }

    .password-reset-container {
        max-width: 500px; /* Increased width */
        margin: 60px auto;
        padding: 40px; /* Increased padding */
        background: #fff;
        border-radius: 10px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }

    h2 {
        font-size: 28px; /* Increased font size */
        font-weight: bold;
    }

    .btn-reset {
        background-color: #ff3c00;
        color: white;
        font-weight: bold;
        border: none;
        padding: 12px;
        font-size: 16px; /* Bigger button */
    }

    .btn-reset:hover {
        background-color: #e62e00;
    }

    .form-label {
        font-weight: bold;
        font-size: 16px;
    }

    .form-control {
        height: 50px; /* Larger input fields */
        font-size: 16px;
    }

    .back-to-login {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: #ff3c00;
        font-weight: bold;
        font-size: 16px;
    }

    .back-to-login:hover {
        text-decoration: underline;
    }
</style>
@include('navbar')
<div class="breadcrumb-section bg-light py-4 mt-5">
    <div class="container text-center">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-2">
                <li class="breadcrumb-item">
                    <a href="{{route('home-view.home')}}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Reset Password</li>
            </ol>
        </nav>
        <!-- Page Title -->
        <h1 class="display-4 fw-bold">Reset Password</h1>
    </div>
</div>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="password-reset-container">
        <h2 class="text-center mb-4">Forgot Password?</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                <input id="email" type="email" class="form-control" name="email" required>
            </div>

            <button type="submit" class="btn btn-reset w-100">Send Password Reset Link</button>

            <a href="{{ route('login') }}" class="back-to-login">Back to Login</a>
        </form>
    </div>
</div>

@endsection
