@extends('home-view.commun')

@section('content')
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
                <li class="breadcrumb-item active" aria-current="page">Register</li>
            </ol>
        </nav>
        <!-- Page Title -->
        <h1 class="display-4 fw-bold">Register</h1>
    </div>
</div>

<div class="container">
    <div class="register-container">
        <h2 class="text-center mb-4">Register</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Role <span class="text-danger">*</span></label>
                <div class="form-check">
                    <input type="radio" id="admin" name="role" value="admin" 
                           class="form-check-input" 
                           @if(auth()->user()->role !== 'admin') disabled @endif>
                    <label for="admin" class="form-check-label 
                           @if(auth()->user()->role !== 'admin') text-muted @endif">
                        Admin @if(auth()->user()->role !== 'admin') (Locked) @endif
                    </label>
                </div>
                
                <div class="form-check">
                    <input type="radio" id="vendor" name="role" value="vendor" class="form-check-input" onclick="toggleVendorFields()">
                    <label for="vendor" class="form-check-label">Vendor</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="patient" name="role" value="patient" class="form-check-input" checked onclick="toggleVendorFields()">
                    <label for="patient" class="form-check-label">Custumor</label>
                </div>
            </div>

            <!-- Vendor Fields (Hidden by Default) -->
            <div id="vendor-fields" class="vendor-fields">
                <div class="mb-3">
                    <label for="shop_name" class="form-label">Shop Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="shop_name" name="shop_name">
                </div>
                <div class="mb-3">
                    <label for="shop_url" class="form-label">Shop URL <span class="text-danger">*</span></label>
                    <input type="url" class="form-control" id="shop_url" name="shop_url">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" id="phone_number" name="phone_number">
                </div>
            </div>

            <!-- Privacy Policy Text -->
            <p class="text-muted mt-3">
                Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="#" class="text-decoration-none">privacy policy</a>.
            </p>

            <button type="submit" class="btn btn-danger w-100">Register</button>

            <p class="text-center mt-3">
                Already have an account? <a href="{{ route('login') }}">Log in</a>
            </p>
        </form>
    </div>
</div>

<script>
    function toggleVendorFields() {
        var vendorFields = document.getElementById('vendor-fields');
        var isVendor = document.getElementById('vendor').checked;

        vendorFields.style.display = isVendor ? 'block' : 'none';

        // Require vendor fields only if "Vendor" is selected
        document.getElementById('shop_name').required = isVendor;
        document.getElementById('shop_url').required = isVendor;
        document.getElementById('phone_number').required = isVendor;
    }
</script>

@endsection
