@extends('home-view.commun')
@section('content')
@if(isset($auctions))
    <p>Favorite Auctions Loaded</p>
@else
    <p>No auctions found.</p>
@endif

@include('navbar')
  <div class="breadcrumb-section bg-light py-4 mt-5">
    <div class="container text-center">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-2">
                <li class="breadcrumb-item">
                    <a href="{{route('home-view.home')}}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Favorite </li>
            </ol>
        </nav>
        <!-- Page Title -->
        <h1 class="display-4 fw-bold">Favorite</h1>
    </div>
</div>
<div class="container">
    <h2 class="mb-4">Your Favorite Auctions</h2>

    <div class="row">
        @forelse ($auctions as $auction)
            <div class="col-md-4 mb-4 p-3">
                <div class="card shadow-lg border-0 rounded">
                    <!-- Car Image -->
                    @if($auction->car && !empty($auction->car->images))
                        @php $images = json_decode($auction->car->images, true); @endphp
                        @if(is_array($images) && count($images) > 0)
                            <img src="{{ asset('storage/' . $images[0]) }}" class="card-img-top rounded-top" alt="Car Image" style="height: 220px; object-fit: cover;">
                        @endif
                    @endif

                    <!-- Card Body -->
                    <div class="card-body">
                        <h5 class="card-title fw-bold">
                            {{ $auction->car->name ?? 'Unknown' }} 
                            <span class="text-muted">({{ $auction->car->brand ?? 'Unknown' }})</span>
                        </h5>
                        
                        <p class="text-muted mb-2">
                            {{ $auction->car->model ?? 'N/A' }} | 
                            {{ $auction->car->color ?? 'N/A' }} | 
                            {{ $auction->car->mileage ?? 'N/A' }} KM | 
                            {{ $auction->car->power ?? 'N/A' }} HP
                        </p>

                        <hr>
                        <p><strong>Last Bid:</strong> ${{ $auction->highest_bid }}</p>
                        <p><strong>Status:</strong> <span class="badge bg-{{ $auction->status === 'ongoing' ? 'success' : 'secondary' }}">{{ ucfirst($auction->status) }}</span></p>

                        <!-- Remove from Favorites Button -->
                        <form action="{{ route('favorites.remove', $auction->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                Remove from Favorites
                            </button>
                        </form>
                        <div class="d-flex justify-content-between mt-2">
                            <a href="{{ route('car.details', $auction->id) }}" class="btn btn-primary btn-sm w-100">View</a>
                            @if($auction->status === 'ongoing')
                                <a href="{{ route('bids.index', $auction->id) }}" class="btn btn-success btn-sm w-100 mx-1">Bid</a>
                            @endif
                            <a href="tel:{{ $auction->car->user->phone_number ?? '' }}" class="btn btn-secondary btn-sm w-100">Call</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>No favorite auctions found.</p>
        @endforelse
    </div>
</div>
@include('home-view.footer')
@endsection