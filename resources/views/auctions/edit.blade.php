@extends('home-view.commun')

@section('content')
@include('navbar')
<div class="breadcrumb-section bg-light py-4 mt-5">
    <div class="container text-center">
         <h1 class="display-4 fw-bold">Edit Auction</h1>
           <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-2">
                <li class="breadcrumb-item">
                    <a href="{{route('home-view.home')}}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
        <!-- Page Title -->
     
    </div>
</div>
<div class="container my-5">
    <h1 class="mb-4">Edit Auction</h1>

    <!-- Display error messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm p-4">
        <form action="{{ route('auctions.update', $auction->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Start Price -->
            <div class="form-group mb-4">
                <label for="start_price" class="form-label">Start Price</label>
                <input type="number" name="start_price" class="form-control" value="{{ $auction->start_price }}" required>
            </div>

            <!-- Start Time -->
            <div class="form-group mb-4">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="datetime-local" name="start_time" class="form-control" value="{{ \Carbon\Carbon::parse($auction->start_time)->format('Y-m-d\TH:i') }}" required>
            </div>

            <!-- Finish Time -->
            <div class="form-group mb-4">
                <label for="finish_time" class="form-label">Finish Time</label>
                <input type="datetime-local" name="finish_time" class="form-control" value="{{ \Carbon\Carbon::parse($auction->finish_time)->format('Y-m-d\TH:i') }}" required>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100">Update Auction</button>
        </form>
    </div>
</div>
@endsection

@push('styles')
    <style>
        .form-group {
            margin-bottom: 1.5rem;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
        }

        .btn {
            padding: 10px 20px;
            font-size: 1.1rem;
        }
    </style>
@endpush
