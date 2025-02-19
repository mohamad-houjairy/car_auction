@extends('home-view.commun')
@section('content')

@include('navbar')

<div class="container-fluid mb-5 mt-5">
    <div class="row">
        <!-- Sidebar -->
        {{-- <nav id="dashboard-sidebar" class="col-md-3 col-lg-2  text-white ">
            <h4 id="sidebar-title" class="text-center py-3">DASHBOARD</h4>
            <ul id="sidebar-menu" class="nav flex-column">
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{route('auctions.manage')}}">ORDERS</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="#">ACCOUNT DETAILS</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="{{route('myaccount-view.createbids')}}">MY AUCTION BIDS</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="#"></a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="#">FAVORITE</a></li>
                <li class="nav-item"><a class="nav-link sidebar-link text-white" href="#">LOG OUT</a></li>
            </ul>
        </nav> --}}

        <!-- Main Content -->
       @yield('commundash')
    </div>
</div>
@include('home-view.footer')
@endsection