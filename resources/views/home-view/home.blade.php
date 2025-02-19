@extends('home-view.commun')
@section('content')
    <section class="home1" id="home">
      @include('navbar')
      <div class="home1-text">
        <h1>
            2019<br>
            Mercedes-Benz<br>
AMG GT-R<br></h1>
Starting Bid from <span style="font-size: 20px;font-weight:700"><u>$240.000</u></span><br>
<div class="home-btn">
    <a href="{{ route('auctions.index2') }}" type="button" class="btn btn-outline-secondary" id="home-btn1">Place Bid</a>
    <a href="{{ route('auctions.index2') }}" type="button" class="btn btn-outline-secondary" id="home-btn2">Check Car</a>
    
</div>
      </div>

     </section>
           @include('home-view.aboutus')
           @include('home-view.new-offer-home')
           @include('home-view.mailbox')
           @include('home-view.footer')
     @endsection
 