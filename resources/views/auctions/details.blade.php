@extends('home-view.commun')

@section('content')
@include('navbar')
<div class="breadcrumb-section bg-light py-4 mt-5">
    <div class="container text-center">
      <div class="title">
       <h3><b>{{ $auction->car->brand }}</b></h3>
      </div>
      <div class="subtitle">
        {{ $auction->car->model }} - {{ $auction->car->color }} - {{ $auction->car->mileage }} km - {{ $auction->car->power }} HP
      </div>
    </div>
</div>

<div class="container my-4">
    <div class="row">
        <!-- Car Image & Gallery -->
        <div class="col-md-6 p-3">
            <div class="card shadow-lg">
                <img id="mainImage" src="{{ asset('storage/' . $auction->car->images[0]) }}" class="img-fluid rounded" alt="">
            </div>

            <!-- Thumbnail Gallery -->
            <div class="thumbnail-container mt-3 d-flex overflow-auto">
                @foreach(json_decode($auction->car->images, true) as $image)
                    <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail thumb-img mx-2" alt="Car Thumbnail" onclick="changeImage(this)">
                @endforeach
            </div>
        </div>

        <!-- Car Details -->
        <div class="col-md-6">
            <h1 class="text title">{{ $auction->car->name ?? 'Unknown Car' }}</h1>
            <p class="text-muted">{{ $auction->car->brand }} - {{ $auction->car->model }}</p>

            <h4 class="text-{{ $auction->status === 'completed' ? 'danger' : 'success' }}">
                {{ $auction->status === 'completed' ? 'Auction Closed' : 'Auction Open' }}
            </h4>

            <p><strong>Starting Price:</strong> ${{ number_format($auction->start_price, 2) }}</p>

            <hr>
            <p><strong>Auction Lot ID:</strong> {{ $auction->id }}</p>
            <p><strong>Category:</strong> Cars</p>
            <p><strong>Tags:</strong> cars, driving, road</p>
            <p><strong>Start time:</strong> {{($auction->start_time) }}</p>
            <p><strong>finish time:</strong> {{($auction->finish_time) }}</p>
        </div>
    </div>

    <div class="row mt-5">
        <!-- Additional Information -->
        <div class="col-md-8">
            <h4>Additional Information</h4>
            <table class="table table-striped">
                <tr><th>Body Type</th><td>{{ $auction->car->body_type }}</td></tr>
                <tr><th>Color</th><td>{{ $auction->car->color }}</td></tr>
                <tr><th>Door Count</th><td>{{ $auction->car->door_count }}</td></tr>
                <tr><th>Mileage</th><td>{{ $auction->car->mileage }} km</td></tr>
                <tr><th>Power</th><td>{{ $auction->car->power }} HP</td></tr>
                <tr><th>Description</th><td>{{ $auction->car->description ?? 'No description available' }}</td></tr>
            </table>
        </div>

        <!-- Vendor Information -->
        <div class="col-md-4">
            <div class="card p-3 shadow-lg">
                <h5>Vendor Details</h5>
                <p><strong>Name:</strong> {{ optional($auction->car->user)->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ optional($auction->car->user)->email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ optional($auction->car->user)->phone_number ?? 'N/A' }}</p>
                <a href="tel:{{ $auction->car->user->phone_number }}" class="btn btn-danger">Contact Vendor</a>
            </div>
        </div>
    </div>

    <!-- Last Bidder Information -->
    @php
        $lastBid = $auction->bids()->latest()->first(); // Fetch the most recent bid
    @endphp
    @if($lastBid)
        <div class="row mt-4">
            <div class="col-md-12">
                <h4 class="text-primary">Auction Winner</h4>
                <p><strong>Bidder Name:</strong> {{ $lastBid->user->name ?? 'Unknown User' }}</p>
                <p><strong>Bid Amount:</strong> ${{ number_format($lastBid->bid_amount, 2) }}</p>
                <p><strong>Bid Time:</strong> {{ $lastBid->created_at->format('M d, Y h:i A') }}</p>
                <p><strong>Selling Price</strong> ${{($currentprice) }}</p>
            </div>
        </div>
    @else
        <div class="row mt-4">
            <div class="col-md-12">
                <h4>No Bids Yet</h4>
                <p>No one has placed a bid yet for this auction.</p>
            </div>
        </div>
    @endif
</div>

<script>
    function changeImage(element) {
        document.getElementById("mainImage").src = element.src;
    }
</script>

<style>
    .title {
        color: #c92b14;
        font-weight: 700;
    }
    .thumbnail-container {
        max-width: 100%;
        white-space: nowrap;
        overflow-x: auto;
        padding-bottom: 10px;
    }
    .thumb-img {
        width: 80px;
        height: 60px;
        cursor: pointer;
        transition: transform 0.3s ease, border 0.3s;
    }
    .thumb-img:hover {
        transform: scale(1.1);
        border: 2px solid #007bff;
    }
    .card img {
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
