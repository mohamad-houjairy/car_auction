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

<div class="container-fluid mb-5 mt-5">
    <div class="row">
@if(auth()->user() && auth()->user()->role === 'admin')
        <!-- Sidebar -->
        <nav id="dashboard-sidebar" class="col-md-3 col-lg-2  text-white ">
            <h4 id="sidebar-title" class="text-center py-3">DASHBOARD</h4>
            <ul id="sidebar-menu" class="nav flex-column">
                    <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{route('users.index')}}">Users</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{ route('auctions.index') }}">Auctions</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{ route('register') }}">Create admin</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{ route('auctions.create') }}">Create Auction</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{ route('myaccount-view.accountdetails', $user) }}">Account Details</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{ route('auctions.index2') }}">SHOP</a></li>

                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{ route('favorites.list') }}">Favorite</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{route('login')}}">LOG OUT</a></li>
            </ul>
        </nav>
@endif
@if(auth()->user() && auth()->user()->role === 'vendor')
        <!-- Sidebar -->
        <nav id="dashboard-sidebar" class="col-md-3 col-lg-2  text-white ">
            <h4 id="sidebar-title" class="text-center py-3">DASHBOARD</h4>
            <ul id="sidebar-menu" class="nav flex-column">
                    <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{route('auctions.my')}}">My Auction</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{ route('users.index') }}">Users</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{ route('auctions.create') }}">Create Auction</a></li>
                                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{ route('myaccount-view.accountdetails', $user) }}">Account Details</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{ route('auctions.index2') }}">SHOP</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{ route('favorites.list') }}">Favorite</a></li>

                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="#">LOG OUT</a></li>
            </ul>
        </nav>
@endif
@if(auth()->user() && auth()->user()->role === 'patient')
        <!-- Sidebar -->
        <nav id="dashboard-sidebar" class="col-md-3 col-lg-2  text-white ">
            <h4 id="sidebar-title" class="text-center py-3">DASHBOARD</h4>
            <ul id="sidebar-menu" class="nav flex-column">
                    <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{ route('auctions.my_bids') }}">My Bid Auction</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{ route('myaccount-view.accountdetails', $user->id) }}">Account Details</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{ route('auctions.index2') }}">SHOP</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{ route('favorites.list') }}">Favorite</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{route('logout')}}">LOG OUT</a></li>
            </ul>
        </nav>
@endif
        <!-- Main Content -->
        <main id="dashboard-content" class="col-md-9 col-lg-10 p-4">
            <div id="welcome-message">
                <h5>Hello <b>{{ old('name', $user->name) }} </b>(not <b>{{ old('name', $user->name) }} </b><a id="logout-link" href="{{route('logout')}}" class="text-danger">Log out</a>)</h5>
                <p>
                    From your account dashboard, you can view your recent orders, manage your shipping and billing
                    addresses, and edit your password and account details.
                </p>
            </div>

            <!-- Auction Quick Links -->
            <div id="auction-quick-links" class="my-5">
                <h3 class="section-title">Auction Quick Links</h3>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card quick-link-card text-center p-4 shadow-sm">
                            <i class="bi bi-gavel" style="font-size: 2rem;"></i>
                            <h5 class="quick-link-title"> <a href="{{route('auctions.my_bids')}} " style="text-decoration: none">My Auction Bids</a></h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card quick-link-card text-center p-4 shadow-sm">
                            <i class="bi bi-eye" style="font-size: 2rem;"></i>
                            <h5 class="quick-link-title"> <a href="{{ route('favorites.list') }}" style="text-decoration: none">My Watchlist</a></h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card quick-link-card text-center p-4 shadow-sm">
                            <i class="bi bi-graph-up" style="font-size: 2rem;"></i>
                            <h5 class="quick-link-title"><a href="{{route('home-view.home')}} " style="text-decoration: none">My Auction Activity</a></h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Become a Vendor -->
            <div id="become-vendor-section" class="text-center mt-5">
                <h4>Become a Vendor</h4>
                <p>Vendors can sell products and manage a store with a vendor dashboard.</p>
                <a href="{{route('register')}}" id="vendor-button" class="btn btn-dark text-danger">Become a Vendor</a>
            </div>
        </main>
    </div>
</div>
@include('home-view.footer')
@endsection