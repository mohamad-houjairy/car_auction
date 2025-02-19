@extends('home-view.commun') <!-- Assuming you have a layout file -->

@section('content')

<style>
    body {
        background-color: #f8f9fa;
    }

    .login-container {
        width: 100%;
        max-width: 400px;
        margin: 50px auto;
        padding: 30px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        font-size: 24px;
        font-weight: bold;
    }

    .btn-login {
        background-color: #ff3c00;
        color: white;
        font-weight: bold;
        border: none;
        padding: 10px;
    }

    .btn-login:hover {
        background-color: #e62e00;
    }

    .password-container {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 15px;
        top: 38px;
        cursor: pointer;
    }

    .forgot-password,
    .register-link {
        display: block;
        text-align: center;
        margin-top: 10px;
    }

    .forgot-password {
        color: #ff3c00;
    }

    .forgot-password:hover {
        text-decoration: underline;
    }
</style>
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
@include('navbar')
  <div class="breadcrumb-section bg-light py-4 mt-5">
    <div class="container text-center">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-2">
                <li class="breadcrumb-item">
                    <a href="{{route('home-view.home')}}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Login</li>
            </ol>
        </nav>
        <!-- Page Title -->
        <h1 class="display-4 fw-bold">Login</h1>
    </div>
</div>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="login-container">
        <h2 class="text-center mb-4">Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">Username or Email Address <span class="text-danger">*</span></label>
                <input id="email" type="email" class="form-control" name="email" required>
            </div>

            <!-- Password Field -->
            <div class="mb-3 password-container">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input id="password" type="password" class="form-control" name="password" required>
                <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
            </div>

            <!-- Remember Me Checkbox -->
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label for="remember" class="form-check-label">Remember Me</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-login w-100">LOG IN</button>

            <!-- Forgot Password & Register Links -->
            <a href="{{ route('password.request') }}" class="forgot-password">Lost your password?</a>
            <a href="{{ route('register') }}" class="register-link">Don't have an account? Register</a>
        </form>
    </div>
</div>

<script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        var icon = document.querySelector(".toggle-password");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
@endsection
