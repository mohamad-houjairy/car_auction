@extends('home-view.commun')

@section('content')
<div class="container">
    <h2>Winner Details</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $winner->name }}</h5>
            <p><strong>Email:</strong> {{ $winner->email }}</p>
            <p><strong>Phone:</strong> {{ $winner->phone_number ?? 'Not available' }}</p>
            
            <div class="d-flex gap-2">
                @if($winner->phone_number)
                    <a href="tel:{{ $winner->phone_number }}" class="btn btn-success">📞 Call Winner</a>
                @endif
                <a href="mailto:{{ $winner->email }}" class="btn btn-primary">✉ Send Email</a>
            </div>
        </div>
    </div>
</div>
@endsection
