@extends('home-view.commun')

@section('content')
@include('navbar')

<div class="container my-5">
    <h1 class="text-center mb-4">Manage Auctions</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Active Auctions Table -->
    <h2 class="text-primary mb-3">Active Auctions</h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Car Name</th>
                <th>Start Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($auctions->where('status', 'ongoing') as $auction)
            <tr>
                <td>{{ $auction->id }}</td>
                <td>{{ $auction->car->name }}</td>
                <td>${{ number_format($auction->start_price, 2) }}</td>
                <td><span class="badge bg-success">{{ ucfirst($auction->status) }}</span></td>
                <td>
                    <a href="{{ route('car.details', $auction->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('auctions.edit', $auction->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('auctions.destroy', $auction->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this auction?');">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pending Auctions Table -->
    <h2 class="text-warning mb-3">Pending Auctions</h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Car Name</th>
                <th>Start Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($auctions->where('status', 'pending') as $auction)
            <tr>
                <td>{{ $auction->id }}</td>
                <td>{{ $auction->car->name }}</td>
                <td>${{ number_format($auction->start_price, 2) }}</td>
                <td><span class="badge bg-warning">{{ ucfirst($auction->status) }}</span></td>
                <td>
                    <a href="{{ route('car.details', $auction->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('auctions.edit', $auction->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('auctions.destroy', $auction->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this auction?');">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Completed Auctions Table -->
    <h2 class="text-secondary mb-3">Completed Auctions</h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Car Name</th>
                <th>Start Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($auctions->where('status', 'completed') as $auction)
            <tr>
                <td>{{ $auction->id }}</td>
                <td>{{ $auction->car->name }}</td>
                <td>${{ number_format($auction->start_price, 2) }}</td>
                <td><span class="badge bg-secondary">{{ ucfirst($auction->status) }}</span></td>
                <td>
                    <a href="{{ route('car.details', $auction->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('auctions.edit', $auction->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('auctions.destroy', $auction->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this auction?');">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

<style>
    .table {
        font-size: 0.9rem;
        border-radius: 8px;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .btn-sm {
        font-size: 0.8rem;
    }

    .badge {
        font-size: 0.8rem;
        padding: 5px 10px;
    }

    .card {
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
    }
</style>
