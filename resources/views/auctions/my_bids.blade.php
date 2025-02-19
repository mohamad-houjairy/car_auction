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
         <h1 class="display-4 fw-bold">My Bid</h1>
           <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-2">
                <li class="breadcrumb-item">
                    <a href="{{route('home-view.home')}}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">My Bid</li>
            </ol>
        </nav>
        <!-- Page Title -->
     
    </div>
</div>
<div class="container mt-5">
    <h3 class="display-6 text-center mb-4">Auctions I Bid On</h3>

    @if($auctions->isEmpty())
        <div class="alert alert-info text-center">
            <p>You haven't placed any bids yet.</p>
        </div>
    @else
        @foreach($auctions as $auction)
            <div class="card mb-4 shadow-sm rounded-3 border-0 auction-card">
                <div class="card-body">
                    <h5 class="card-title text-custom-orange">
                        {{ $auction->car->name }}
                        <span class="badge badge-{{ $auction->status === 'completed' ? 'secondary' : 'success' }} ms-2">
                            {{ ucfirst($auction->status) }}
                        </span>
                    </h5>
                    <p class="card-text">
                        <strong>Start Price:</strong> ${{ number_format($auction->start_price, 2) }}
                    </p>
                    <p class="card-text">
                        <strong>Start Time:</strong> {{ $auction->start_time }}
                    </p>
                    <p class="card-text">
                        <strong>Finish Time:</strong> {{ $auction->finish_time }}
                    </p>
                    
                    <!-- Bids Information -->
                    <h6 class="fw-bold mt-3">Your Bids:</h6>
                    <ul class="list-group list-group-flush mb-3">
                        @foreach($auction->bids as $bid)
                            <li class="list-group-item py-2 bid-item">
                                ${{ number_format($bid->bid_amount, 2) }} placed on 
                                <span class="text-muted">{{ $bid->created_at->format('M d, Y h:i A') }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('car.details', $auction->id) }}" class="btn btn-primary btn-sm custom-button">
                       <b> View Auction</b>
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>

<style>
    .text-custom-orange {
        color: #c92b14 !important;
    }
    .auction-card {
        border: 1px solid #e0e0e0;
    }
    .bid-item {
        background-color: #f8f9fa;
        border-left: 3px solid #c92b14;
    }
    .custom-button {
        background-color: #c92b14;
        border-color: #c92b14;
    }
    .custom-button:hover {
    
        background-color: #b92c1300;
        border-color: #b92b13;
        color: black
        
    }
</style>
@endsection