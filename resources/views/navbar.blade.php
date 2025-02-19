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
                  <a class="nav-link text-black-50 font-weight-bold" href="{{ route('auctions.index2') }}" id="ul-a">Shop</a>
                </li>
                <li class="nav-item" style="margin-left: 10px;font-weight: bold">
                  <a class="nav-link text-black-50" href="#aboutus">About Us</a>
                </li>
                <li class="nav-item " style="margin-left: 10px;font-weight: bold">
                  <a class="nav-link text-black-50" href="{{ route('myaccount-view.myaccount') }}">My Account</a>
                </li>
                <li class="nav-item" style="margin-left: 10px;font-weight: bold">
                  <a class="nav-link text-black-50" href="{{ route('favorites.list') }}">Favorite</a>
                </li>
                <li class="nav-item" style="margin-left: 10px;font-weight: bold">
                  <a class="nav-link text-black-50" href="{{ route('notifications.index') }}">Notifications</a>
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