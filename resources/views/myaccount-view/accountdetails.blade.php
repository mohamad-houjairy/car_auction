@extends('myaccount-view.commundash')
@section('commundash')
<div class="breadcrumb-section bg-light py-4 mt-5">
    <div class="container text-center"> 
         <h1 class="display-4 fw-bold">Edit Account</h1>
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-2">
                <li class="breadcrumb-item">
                    <a href="{{route('home-view.home')}}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">edit account</li>
            </ol>
        </nav>
        <!-- Page Title -->
      
    </div>
</div>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4 w-100" style="max-width: 500px;">
        <h2 class="text-center mb-4">Edit Profile</h2>
        
        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <form action="{{ route('profile.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <!-- Phone Number -->
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number) }}">
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">New Password (optional)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <!-- Save Button -->
            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
        </form>
    </div>
</div>


@push('styles')
<style>
    .container {
        padding: 20px;
    }

    .card {
        border-radius: 15px;
        background: #fff;
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        border-radius: 10px;
        font-weight: bold;
        padding: 10px;
        background: #007bff;
        transition: 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background: #0056b3;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
        border: 1px solid #ddd;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    @media (max-width: 576px) {
        .card {
            padding: 20px;
        }
    }
</style>
@endpush
@endsection


