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
                <li class="breadcrumb-item active" aria-current="page">Notifcations</li>
            </ol>
        </nav>
        <!-- Page Title -->
        <h1 class="display-4 fw-bold">Notifications</h1>
    </div>
</div>
<div class="container mt-5">
    <h1 class="text-center mb-4">Your Notifications</h1>
    
    @if($notifications->isEmpty())
        <p class="text-center">No new notifications.</p>
    @else
        <div class="notification-list">
            @foreach($notifications as $notification)
                <div class="alert {{ $notification->read_at ? 'alert-secondary' : 'alert-info' }} mb-3 shadow-lg rounded-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>{{ $notification->data['message'] }}</strong>
                        @if(!$notification->read_at)
                            <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="mb-0">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary">Mark as Read</button>
                            </form>
                        @endif
                    </div>
                    <div class="mt-2 text-end">
                        <a href="{{ route('car.details', $notification->data['auction_id']) }}" class="btn btn-sm btn-primary">View Auction</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
<style>
    /* Custom styles for notifications */
.notification-list {
    max-width: 800px;
    margin: 0 auto;
}

.alert {
    position: relative;
    padding: 1.25rem;
}

.alert .btn {
    margin-left: 10px;
}

.alert-info {
    background-color: #d1ecf1;
    color: #0c5460;
}

.alert-secondary {
    background-color: #e2e3e5;
    color: #383d41;
}

.alert-info strong {
    font-size: 1.1rem;
}

.btn-outline-primary {
    border-color: #007bff;
    color: #007bff;
    background-color: transparent;
}

.btn-outline-primary:hover {
    background-color: #007bff;
    color: white;
}

@media (max-width: 767px) {
    .notification-list {
        padding-left: 15px;
        padding-right: 15px;
    }
}

</style>
@endsection
