@extends('home-view.commun')

@section('content')
    <div class="container">
        <h2>Your Notifications</h2>

        <ul class="list-group">
            @foreach ($notifications as $notification)
                <li class="list-group-item">
                    <!-- Display the message -->
                    <p>{{ $notification->data['message'] }}</p>

                    <!-- Button to mark as read -->
                    <a href="{{ route('auction.show', $notification->data['auction_id']) }}" class="btn btn-primary">
                        View Auction Details
                    </a>

                    <form action="{{ route('notification.markAsRead', $notification->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-success">Mark as Read</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
