@extends('home-view.commun')

@section('content')
<div class="container">
    <h2>Vendor Details</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $vendor->name }}</h5>
            <p><strong>Email:</strong> {{ $vendor->email }}</p>
            <p><strong>Phone:</strong> {{ $vendor->phone_number ?? 'Not available' }}</p>
            
            <div class="d-flex gap-2">
                @if($vendor->phone_number)
                    <a href="tel:{{ $vendor->phone_number }}" class="btn btn-success">📞 Call Vendor</a>
                @endif
                <a href="mailto:{{ $vendor->email }}" class="btn btn-primary">✉ Send Email</a>
            </div>
        </div>
    </div>
</div>
@endsection
