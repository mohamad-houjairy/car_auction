@extends('home-view.commun')

@section('content')
@include('navbar')

<div class="breadcrumb-section bg-light py-4 mt-5">
    <div class="container text-center">
         <h1 class="display-4 fw-bold">User Management</h1>
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-2">
                <li class="breadcrumb-item">
                    <a href="{{route('home-view.home')}}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Users </li>
            </ol>
        </nav>
    </div>
</div>
<div class="container my-5">
    <h1 class="text-center mb-4">Edit User</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name Field -->
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>

                <!-- Email Field -->
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>

                <!-- Role Selection -->
                <div class="form-group mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="vendor" {{ $user->role == 'vendor' ? 'selected' : '' }}>Vendor</option>
                        <option value="patient" {{ $user->role == 'patient' ? 'selected' : '' }}>Patient</option>
                    </select>
                </div>

                <!-- Vendor Fields (shown only if the role is 'vendor') -->
                @if($user->role == 'vendor')
                    <div class="form-group mb-3">
                        <label for="shop_name" class="form-label">Shop Name</label>
                        <input type="text" name="shop_name" class="form-control" value="{{ $user->shop_name }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="shop_url" class="form-label">Shop URL</label>
                        <input type="url" name="shop_url" class="form-control" value="{{ $user->shop_url }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control" value="{{ $user->phone_number }}">
                    </div>
                @endif

                <!-- Password Fields -->
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Password (leave blank to keep current)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <style>
        /* Custom Styling */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .card {
            border-radius: 15px;
        }

        .card-body {
            padding: 2rem;
        }

        .btn-success {
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 25px;
        }

        .form-control, .form-select {
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-label {
            font-weight: bold;
            font-size: 1.1rem;
        }

        .d-flex {
            display: flex;
            justify-content: center;
        }

        .alert {
            margin-bottom: 1.5rem;
        }
    </style>
@endsection

