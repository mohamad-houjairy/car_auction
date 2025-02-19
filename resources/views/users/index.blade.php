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
                <li class="breadcrumb-item active" aria-current="page">Users</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container my-5">
    <h1 class="text-center mb-5">User Management</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <!-- Admin Users Table -->
        <h2 class="text-center mb-4">Admins</h2>
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users->where('role', 'admin') as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <hr class="my-4">

        <!-- Vendor Users Table -->
        <h2 class="text-center mb-4">Vendors</h2>
        <table class="table table-bordered">
            <thead class="table-warning">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users->where('role', 'vendor') as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <hr class="my-4">

        <!-- Patient Users Table -->
        <h2 class="text-center mb-4">Custumor</h2>
        <table class="table table-bordered">
            <thead class="table-success">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users->where('role', 'patient') as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>




    <style>
        .table-bordered th, .table-bordered td {
            border: 2px solid #dee2e6; /* Darker border for better visibility */
        }

        .table-primary {
            background-color: #b8daff; /* Light blue */
        }

        .table-warning {
            background-color: #ffeeba; /* Light yellow */
        }

        .table-success {
            background-color: #c3e6cb; /* Light green */
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        hr {
            border: 1px solid #ddd;
        }

        /* Add responsive styles */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
@endsection
