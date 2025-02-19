{{-- @extends('home-view.commun')

@section('content')
<nav class="navbar navbar-expand-lg bg-body-tertiary py-0">
    <div class="container-fluid " style="margin-left: 50px">
        <img src="/image/logo2.png" class="img-fluid" alt="Logo" />
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav m-3 ">
                <ul class="nav nav-underline" id="nav-ul">
                    <li class="nav-item " style="margin-left: 30px ;font-weight: bold">
                        <a class="nav-link active" aria-current="page" href="{{ route('home-view.home') }}">Home</a>
                    </li>
                    <li class="nav-item " style="margin-left: 10px;font-weight: bold">
                        <a class="nav-link text-black-50 font-weight-bold" href="{{ route('shope-view.shope') }}" id="ul-a">Shope</a>
                    </li>
                    <li class="nav-item" style="margin-left: 10px;font-weight: bold">
                        <a class="nav-link text-black-50" href="{{ route('home-view.home') }}#aboutus">About Us</a>
                    </li>
                    <li class="nav-item " style="margin-left: 10px;font-weight: bold">
                        <a class="nav-link text-black-50" href="#">My Account</a>
                    </li>
                    <li class="nav-item" style="margin-left: 10px;font-weight: bold">
                        <a class="nav-link text-black-50" href="#">Favorite</a>
                    </li>
                </ul>
                <button type="button" class="btn btn-outline-secondary " id="home-login">Login</button>
            </div>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <h2>Register</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="vendor">Vendor</option>
                <option value="patient">Patient</option>
            </select>
        </div>

        <!-- Vendor-specific fields -->
        <div id="vendor-fields" style="display: none;">
            <div class="mb-3">
                <label for="shop_name" class="form-label">Shop Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="shop_name" name="shop_name">
            </div>
            <div class="mb-3">
                <label for="shop_url" class="form-label">Shop URL <span class="text-danger">*</span></label>
                <input type="url" class="form-control" id="shop_url" name="shop_url">
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
@endsection --}}