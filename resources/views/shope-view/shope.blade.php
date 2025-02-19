{{-- @extends('home-view.commun')
@section('content')
<nav class="navbar navbar-expand-lg bg-body-tertiary py-0">
    <div class="container-fluid " style="margin-left: 50px">
        <img src="/image/logo2.png" class="img-fluid" alt="Logo" />
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav m-3 " >
            <ul class="nav nav-underline" id="nav-ul">
                <li class="nav-item " style="margin-left: 30px ;font-weight: bold">
                  <a class="nav-link active" aria-current="page" href="{{ route('home-view.home') }}">Home</a>
                </li>
                <li class="nav-item " style="margin-left: 10px;font-weight: bold">
                  <a class="nav-link text-black-50 font-weight-bold" href="{{ route('auctions.index2') }}" id="ul-a">Shope</a>
                </li>
                <li class="nav-item" style="margin-left: 10px;font-weight: bold">
                  <a class="nav-link text-black-50" href="#aboutus">About Us</a>
                </li>
                <li class="nav-item " style="margin-left: 10px;font-weight: bold">
                  <a class="nav-link text-black-50" href="{{ route('myaccount-view.myaccount') }}">My Account</a>
                </li>
                <li class="nav-item" style="margin-left: 10px;font-weight: bold">
                  <a class="nav-link text-black-50" href="{{ route('favorite-view.favorite') }}">Favorite</a>
                </li>
                
              </ul>
              @if (Auth::check())
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <a  href="{{ route('login') }}" type="button" class="btn btn-outline-secondary " id="home-login">Logout</a>
</form>
@else
<a href="{{ route('login') }}" type="button" class="btn btn-outline-secondary " id="home-login">Login</a>

@endif

             
        </div>
      </div>
    </div>
  </nav>
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
        <h1 class="display-4 fw-bold">Auctions</h1>
    </div>
</div>

<div class="container mt-5 mb-5">
  <div class="row">
      <!-- Sidebar -->
      <div class="col-md-3">
          <div class="card">
              <div class="card-header">
                  <h5>Filters:</h5>
              </div>
              <div class="card-body">
                  <h6 class="fw-bold mb-3">Car Models</h6>
                  <div class="list-group">
                      <!-- Links for Filters -->
                      <a href="/car_model/audi" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                          Audi
                          <span class="badge bg-primary rounded-pill">5</span>
                      </a>
                      <a href="/car_model/bmw" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                          BMW
                          <span class="badge bg-primary rounded-pill">6</span>
                      </a>
                      <a href="/car_model/dacia" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                          Dacia
                          <span class="badge bg-primary rounded-pill">3</span>
                      </a>
                      <a href="/car_model/ford" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                          Ford
                          <span class="badge bg-primary rounded-pill">3</span>
                      </a>
                      <a href="/car_model/lamborghini" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                          Lamborghini
                          <span class="badge bg-primary rounded-pill">1</span>
                      </a>
                      <a href="/car_model/mazda" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                          Mazda
                          <span class="badge bg-primary rounded-pill">0</span>
                      </a>
                      <a href="/car_model/mercedes-benz" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                          Mercedes-Benz
                          <span class="badge bg-primary rounded-pill">4</span>
                      </a>
                  </div>
              </div>
          </div>
      </div>
      <!-- Content Area -->
  </div>
</div>

@include('home-view.footer')
@endsection --}}