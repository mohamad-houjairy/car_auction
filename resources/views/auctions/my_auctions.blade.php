@extends('home-view.commun')

@section('content')
@include('navbar')
@if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
<div class="breadcrumb-section bg-light py-4 mt-5">
    <div class="container text-center">
         <h1 class="display-4 fw-bold">My Auctions</h1>
           <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-2">
                <li class="breadcrumb-item">
                    <a href="{{route('home-view.home')}}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">My Auction</li>
            </ol>
        </nav>
        <!-- Page Title -->
     
    </div>
</div>
<div class="container my-5">
    <h1 class="text-center mb-4">My Auctions</h1>

    @if($groupedAuctions->isEmpty())
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> <strong>No auctions found!</strong> You haven't created any auctions yet.
        </div>
    @else
        @foreach($groupedAuctions as $status => $auctions)
            <div class="auction-status mt-5">
                <h2 class="text-uppercase">
                    <i class="fas fa-gavel"></i> {{ ucfirst($status) }} Auctions
                </h2>
                <hr>

                @if($auctions->isEmpty())
                    <p class="text-center text-muted">No {{ $status }} auctions.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Car Name</th>
                                    <th>Start Price</th>
                                    <th>Start Time</th>
                                    <th>Finish Time</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($auctions as $auction)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $auction->car->name }}</td>
                                        <td>${{ number_format($auction->start_price, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($auction->start_time)->format('d M Y H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($auction->finish_time)->format('d M Y H:i') }}</td>
                                        
                                        <td class="text-center">
                                            <a href="{{ route('car.details', $auction->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="{{ route('auctions.edit', $auction->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('auctions.destroy', $auction->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endforeach
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Container styling */
    .container {
        max-width: 1100px;
    }

    /* Table styling */
    .table {
        border-radius: 8px;
        overflow: hidden;
    }

    .table th {
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background-color: #21252957
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: 0.3s ease-in-out;
    }

    /* Icons */
    .btn i {
        margin-right: 5px;
    }

    /* Buttons */
    .btn-sm {
        padding: 6px 12px;
        font-size: 0.875rem;
    }

    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    /* Alert */
    .alert-info {
        font-size: 1.2rem;
        padding: 15px;
        border-radius: 8px;
    }

    /* Auction Status */
    .auction-status h2 {
        font-size: 1.5rem;
        color: #343a40;
        display: flex;
        align-items: center;
    }

    .auction-status h2 i {
        margin-right: 10px;
        color: #007bff;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .table {
            font-size: 0.9rem;
        }

        .btn-sm {
            padding: 5px 8px;
            font-size: 0.8rem;
        }
    }
</style>
@endpush