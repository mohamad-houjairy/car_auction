@extends('home-view.commun')

@section('content')
@include('navbar')
<div class="breadcrumb-section bg-light py-4 mt-5">
    <div class="container text-center">
         <h1 class="display-4 fw-bold">Create Auction</h1>
           <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-2">
                <li class="breadcrumb-item">
                    <a href="{{route('home-view.home')}}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Auction</li>
            </ol>
        </nav>
        <!-- Page Title -->
     
    </div>
</div>
<div class="container my-5">
    <div class="card22 shadow-lg p-4" style="background-color: #f3f5f9;">
        <h2 class="mb-4 text-center text-primary"><i class="fas fa-gavel"></i> Create Auction</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('auctions.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6 col6 p-5">
                    <div class="form-group mb-3">
                        <label for="name" class="text-dark"><i class="fas fa-car text-primary"></i> Car Name</label>
                        <input type="text" name="name" class="form-control border border-primary" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="brand" class="text-dark"><i class="fas fa-industry text-warning"></i> Brand</label>
                        <input type="text" name="brand" class="form-control border border-warning" value="{{ old('brand') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="model" class="text-dark"><i class="fas fa-car-side text-success"></i> Model</label>
                        <input type="text" name="model" class="form-control border border-success" value="{{ old('model') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="body_type" class="text-dark"><i class="fas fa-cube text-danger"></i> Body Type</label>
                        <input type="text" name="body_type" class="form-control border border-danger" value="{{ old('body_type') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="color" class="text-dark"><i class="fas fa-palette text-info"></i> Color</label>
                        <input type="text" name="color" class="form-control border border-info" value="{{ old('color') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="door_count" class="text-dark"><i class="fas fa-door-open text-secondary"></i> Door Count</label>
                        <input type="number" name="door_count" class="form-control border border-secondary" value="{{ old('door_count') }}" required>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6 col6 p-5">
                    <div class="form-group mb-3">
                        <label for="mileage" class="text-dark"><i class="fas fa-tachometer-alt text-purple"></i> Mileage (km)</label>
                        <input type="number" name="mileage" class="form-control border border-purple" value="{{ old('mileage') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="power" class="text-dark"><i class="fas fa-bolt text-pink"></i> Power (HP)</label>
                        <input type="number" name="power" class="form-control border border-pink" value="{{ old('power') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="start_price" class="text-dark"><i class="fas fa-dollar-sign text-success"></i> Start Price</label>
                        <input type="number" name="start_price" class="form-control border border-success" value="{{ old('start_price') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="start_time" class="text-dark"><i class="fas fa-clock text-warning"></i> Start Time</label>
                        <input type="datetime-local" name="start_time" class="form-control border border-warning" value="{{ old('start_time') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="finish_time" class="text-dark"><i class="fas fa-hourglass-end text-danger"></i> Finish Time</label>
                        <input type="datetime-local" name="finish_time" class="form-control border border-danger" value="{{ old('finish_time') }}" required>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="form-group mb-3">
                <label for="description" class="text-dark"><i class="fas fa-align-left text-info"></i> Description</label>
                <textarea name="description" class="form-control border border-info" rows="3">{{ old('description') }}</textarea>
            </div>

            <!-- Image Upload -->
            <div class="form-group mb-3">
                <label for="images" class="text-dark"><i class="fas fa-camera text-purple"></i> Upload Car Images</label>
                <input type="file" name="images[]" class="form-control border border-purple" multiple onchange="previewImages(event)">
                <div id="image-preview" class="d-flex flex-wrap mt-2"></div>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-gradient"><i class="fas fa-check-circle"></i> Create Auction</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
   
    .card22 {
        border-radius: 10px;
        background-color: #f8f9fa;
        box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1);
    }

    .form-group label {
        font-weight: bold;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #ff7eb3, #ff758c, #ffb199);
        color: white;
        font-size: 1.2rem;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        transition: 0.3s;
    }

    .btn-gradient:hover {
        background: linear-gradient(135deg, #ff758c, #ff7eb3);
        color: white;
        transform: scale(1.05);
    }

    .fa {
        margin-right: 5px;
    }

    /* Image Preview */
    #image-preview img {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 5px;
        margin: 5px;
        border: 2px solid #970000;
        padding: 3px;
    }
</style>
@endpush

@push('scripts')
<script>
    function previewImages(event) {
        let preview = document.getElementById('image-preview');
        preview.innerHTML = "";
        Array.from(event.target.files).forEach(file => {
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = document.createElement('img');
                img.src = e.target.result;
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
@endpush
@endsection
