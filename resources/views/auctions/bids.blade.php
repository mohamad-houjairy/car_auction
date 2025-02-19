@extends('home-view.commun')

@section('content')
@include('navbar')
<div class="breadcrumb-section bg-light py-4 mt-5">
    <div class="container text-center">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-2">
                <li class="breadcrumb-item">
                    <a href="{{route('home-view.home')}}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Shop</li>
            </ol>
        </nav>
        <!-- Page Title -->
        <h1 class="display-4 fw-bold">My Account</h1>
    </div>
</div>
<div class="container mt-4">
    <h2 class="mb-4 text-center">{{ $auction->car->name }} Auction</h2>

    <div class="row">
        <div class="col-md-6">
            <h4>Car Details</h4>
            <p><strong>Brand:</strong> {{ $auction->car->brand }}</p>
            <p><strong>Model:</strong> {{ $auction->car->model }}</p>
            <p><strong>Description:</strong> {{ $auction->car->description }}</p>
            <p><strong>Starting Price:</strong> ${{ $auction->start_price }}</p>
            <p><strong>Vendor:</strong> {{ $auction->car->user->name }}</p>
            <p><strong>Vendor Phone:</strong> {{ $auction->car->user->phone_number }}</p>
            <a href="tel:{{ $auction->car->user->phone_number }}" class="btn btn-primary">Call Vendor</a>
        </div>

        <div class="col-md-6">
            <h4>Auction Status: {{ ucfirst($auction->status) }}</h4>

            <!-- Display success message if bid was placed -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <h4>Bid History</h4>
            <ul>
                @foreach($auction->bids as $bid)
                    <li>{{ $bid->user->name }}: ${{ $bid->bid_amount }} at {{ $bid->created_at }}</li>
                @endforeach
            </ul>

            @if($auction->status === 'ongoing')
                <h4>Place a Bid</h4>
                
                <!-- Bid Form -->
                <form action="{{ route('bids.store', $auction->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="bid_amount">Bid Amount</label>
                        <input type="number" name="bid_amount" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Submit Bid</button>
                </form>

            @else
                <p class="text-danger">Bidding is closed for this auction.</p>
            @endif
        </div>
    </div>
</div>
@endsection
