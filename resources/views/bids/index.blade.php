@extends('home-view.commun')

@section('content')

<!-- Success & Error Messages -->
@if(session('success'))
    <div class="alert alert-success auction-alert">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger auction-alert">
        {{ session('error') }}
    </div>
@endif
@if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @include('navbar')
<div class="breadcrumb-section bg-light py-4 mt-5">
    <div class="container text-center">
         <h1 class="display-4 fw-bold">Add Bid</h1>
           <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-2">
                <li class="breadcrumb-item">
                    <a href="{{route('home-view.home')}}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Add Bid</li>
            </ol>
        </nav>
        <!-- Page Title -->
     
    </div>
</div>

<div class="container auction-container">
    <div class="card auction-card shadow-lg">
        <div class="card-header auction-header text-center">
            <h2 class="text-black">🏆<b> Place Your Bid</b></h2>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Car Image -->
                <div class="col-md-6 p-3">
                    @if($auction->car && !empty($auction->car->images))
                @php $images = json_decode($auction->car->images, true); @endphp
                @if(is_array($images) && count($images) > 0)
                    <img src="{{ asset('storage/' . $images[0]) }}" class="card-img-top rounded-top" alt="Car Image" style="height: 220px; object-fit: cover;">
                @endif
            @endif
                </div>

                <!-- Car Details -->
                <div class="col-md-6 p-3">
                    <h4 class="text-secondary">{{ $auction->car->name }} ({{ $auction->car->brand }})</h4>
                    <p><strong>💰 Start Price:</strong> <span class="text-success">${{ number_format($auction->start_price, 2) }}</span></p>
                    <p><strong>⚡ Auction Price:</strong> <span class="text-danger">${{ number_format($updated_price, 2) }}</span></p>
                    <p><strong>⏳ Auction Ends:</strong> {{ $auction->finish_time }}</p>
                    
                    <!-- Last Bids -->
                    <h5 class="text-info">📜 Last Bids:</h5>
                    @if($lastBids->isNotEmpty())
                        <ul class="list-group bid-list">
                            @foreach($lastBids as $bid)
                                <li class="list-group-item bid-item">
                                    <strong>{{ $bid->user->name }}</strong>
                                    <span class="text-success">${{ number_format($bid->bid_amount, 2) }}</span>
                                    <small class="text-muted">{{ $bid->created_at->format('M d, Y h:i A') }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No bids have been placed yet.</p>
                    @endif
                </div>
            </div>

            <!-- Bid Submission Form -->
            <div class="mt-4 bid-form">
                <h4 class="text-black">⚡ Enter Your Bid</h4>
                <!-- Fixed Hint for Bidders -->
<div class="alert alert-danger">
    ℹ️ Bidding Rules:
    <ul class="mb-0">
        <li>🚫 You cannot place consecutive bids. Wait for another user to bid first.</li>
        <li>⚠️ Your bid must not exceed 150% of the last bid.</li>
        <li>💰 The minimum bid amount is $250.</li>
    </ul>
</div>

                <form action="{{ route('bids.store', $auction->id) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="number" step="0.01" class="form-control bid-input" name="bid_amount" required min="250" placeholder="Enter bid amount">
                        <button type="submit" class="btn btn-success bid-button">Submit Bid</button>
                    </div>
                </form>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('auctions.index2') }}" class="btn btn-secondary shop-button">🏪 Shop</a>

                @if (auth()->check() && (auth()->user()->role === 'vendor' && auth()->user()->id === $auction->user_id || auth()->user()->role === 'admin'))
                    
                    @if($auction->status == 'ongoing')
                        <form action="{{ route('auctions.end', $auction->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger end-auction-button">End Auction</button>
                        </form>
                    @endif 
                
                @endif
                
            </div>
        </div>
    </div>
</div>

@endsection
