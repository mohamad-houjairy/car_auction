@php
    use App\Models\Auction;
@endphp

@extends('home-view.commun')

@section('content')
@include('navbar')
<div class="breadcrumb-section bg-light py-4 mt-5">
    <div class="container text-center">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('home-view.home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Auctions</li>
            </ol>
        </nav>
        <!-- Page Title -->
        <h1 class="display-4 fw-bold">Auctions</h1>
    </div>
</div>


<div class="conta m-3">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-md-3">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white">
                    <h5>Filters</h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Car Names</h6>
                    <div class="list-group">
                        @foreach($carNames as $car)
                            <a href="{{ route('auctions.index2', ['name' => $car->name]) }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                {{ $car->name }}
                                <span class="badge bg-primary rounded-pill">
                                    {{ $nameCounts[$car->name] ?? 0 }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Content Area -->
        <div class="col-md-9">
            <div class="row">
                @if($auctions && $auctions->isNotEmpty())
                @foreach($auctions as $auction)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-lg border-0 rounded position-relative">
                        <!-- Car Image -->
                        @if($auction->car && !empty($auction->car->images))
                            @php $images = json_decode($auction->car->images, true); @endphp
                            @if(is_array($images) && count($images) > 0)
                                <img src="{{ asset('storage/' . $images[0]) }}" class="card-img-top rounded-top" alt="Car Image" style="height: 220px; object-fit: cover;">
                            @endif
                        @endif
            
                        <!-- Favorite Love Icon -->
                        @php
                            $favorites = session('favorites', []);
                            $isFavorite = in_array($auction->id, $favorites);
                        @endphp
                        <form action="{{ $isFavorite ? route('favorites.remove', $auction->id) : route('favorites.add', $auction->id) }}" method="POST" class="position-absolute top-0 end-0 m-3">
                            @csrf
                            <button type="submit" class="btn p-0">
                                <i class="fa{{ $isFavorite ? 's' : 'r' }} fa-heart fa-2x text-danger"></i>
                            </button>
                        </form>
            
                        <!-- Card Body -->
                        <div class="card-body">
                            <h5 class="card-title fw-bold">
                                {{ $auction->car->name ?? 'Unknown' }} 
                                <span class="text-muted">({{ $auction->car->brand ?? 'Unknown' }})</span>
                            </h5>
                            
                            <!-- Car Details -->
                            <p class="text-muted">
                                {{ $auction->car->model ?? 'N/A' }} | 
                                {{ $auction->car->color ?? 'N/A' }} | 
                                {{ $auction->car->mileage ?? 'N/A' }} KM | 
                                {{ $auction->car->power ?? 'N/A' }} HP
                            </p>
                            <p><strong>start price</strong> ${{ $auction->start_price}}</p>
                            <p><strong>Last Bid:</strong> ${{ $auction->highest_bid }}</p>
                            <p><strong>Status:</strong> <span class="badge bg-{{ $auction->status === 'ongoing' ? 'success' : 'secondary' }}">{{ ucfirst($auction->status) }}</span></p>
            
                            <!-- Action Buttons -->
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
            @endforeach
            

            
                @else
                    <div class="col-12">
                        <p class="text-center text-muted">No auctions available at this time.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@include('home-view.footer')
<script>
    $(document).ready(function() {
        $('.favorite-btn').on('click', function() {
            var auctionId = $(this).data('auction-id');
            var button = $(this);

            $.ajax({
                url: '/auction/' + auctionId + '/favorite',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // Update the button text and class
                    if (button.hasClass('btn-outline-danger')) {
                        button.removeClass('btn-outline-danger').addClass('btn-danger').text('Remove from Favorites');
                    } else {
                        button.removeClass('btn-danger').addClass('btn-outline-danger').text('Add to Favorites');
                    }
                },
                error: function(error) {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
</script>

<style>
    .card-title{
        color: #c92b14;!important
    }
    /* Breadcrumb Styling */
    .breadcrumb-section {
        border-radius: 5px;
        font-size: 1.2rem;
    }

    .breadcrumb a {
        text-decoration: none;
        font-weight: bold;
    }

    /* Card Styling */
    .card {
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        transform: scale(1.03);
    }

    /* Buttons */
    .btn-secondary,.btn-success{
        border-radius: 8px;
        font-weight: bold;
        margin: 2px;
        transition: all 0.3s ease-in-out;
    }
    .btn-primary{
        border-radius: 8px;
        font-weight: bold;
        margin: 2px;
        transition: all 0.3s ease-in-out;
        background-color: #c92b14
    }

    .btn-primary:hover {
        background-color: #0057b300;
        color: black
    }

    .btn-success:hover {
        background-color: #19875400;
        color: black
    }

    .btn-secondary:hover {
        background-color: #6c757d00;
        color: black
    }
    .mb-4{
        padding: 10px;
    }
</style>



@endsection
