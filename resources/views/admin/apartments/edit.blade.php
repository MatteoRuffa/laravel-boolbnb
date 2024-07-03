@section('title', 'Edit Apartments {{ $apartment->name }}')
@extends('layouts.admin')

@section('content')
    <section class="container py-5">
        <div class="container rounded-2 p-5 container-table">
            <h1 class=" text-black fw-bolder text-uppercase">Modify apartment: {{ $apartment->title }}</h1>

           

            <form id="edit-apartment-form" action="{{ route('admin.apartments.update', $apartment->slug) }}" method="POST" novalidate

                enctype="multipart/form-data">
                @csrf

                @method('PUT')

            <div class="row">

                <div class="mb-3 col @error('name') @enderror">
                    <label for="name" class="form-label fs-5 fw-medium">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name', $apartment->name) }}" maxlength="255"
                        minlength="3">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col @error('rooms') @enderror">
                    <label for="rooms" class="form-label fs-5 fw-medium">Rooms</label>
                    <input type="number" class="form-control @error('rooms') is-invalid @enderror"
                        id="rooms" name="rooms" value="{{ old('rooms', $apartment->rooms) }}">
                    @error('rooms')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="row">
                <div class="mb-3 col @error('beds') @enderror">
                    <label for="beds" class="form-label fs-5 fw-medium">Beds</label>
                    <input type="number"
                        class="form-control @error('beds') is-invalid @enderror"
                        id="beds" name="beds"
                        value="{{ old('beds', $apartment->beds) }}" minlength="2">
                    @error('beds')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>



                <div class="mb-3 col @error('bathrooms') @enderror">
                    <label for="bathrooms" class="form-label fs-5 fw-medium">Bathrooms</label>
                    <input type="number" class="form-control @error('bathrooms') is-invalid @enderror" id="bathrooms" name="bathrooms"
                       placeholder="{{ old('bathrooms', $apartment->bathrooms) }}" >
                    @error('bathrooms')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col @error('square_meters') @enderror">
                    <label for="square_meters" class="form-label fs-5 fw-medium">Square meters</label>
                    <input type="number" class="form-control @error('square_meters') is-invalid @enderror" id="square_meters" name="square_meters"
                        placeholder="{{ old('square_meters', $apartment->square_meters) }}">
                    @error('square_meters')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>


                <div class="mb-3 @error('description') @enderror">
                    <label for="description" class="form-label fs-5 fw-medium">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description"  >{{ old('description',  $apartment->description) }}</textarea>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <h5>Address:</h5>
                <div class="address">
                    <div class="mb-3 @error('address') @enderror">
                        <label for="address" class="form-label fs-5 fw-medium">Address</label>
                        <input class="form-control @error('address') is-invalid @enderror" type="text" id="address" name="address" value="{{ old('address', $apartment->address) }}" required maxlength="255" minlength="7">
                        <div id="resultsContainer" class="results-container w-50"></div>
                        @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>  
                </div>
            
                {{-- <div class="mb-3 @error('image_cover') @enderror d-flex gap-5 align-items-center">
                    <div class="w-25">
                        @if ($movie->image_cover && strpos($movie->image_cover, 'http') !== false)
                            <img id="uploadPreview" class="w-100 uploadPreview" width="100"
                                src="{{ $movie->image_cover }}" alt="preview">
                        @elseif ($movie->image_cover)
                            <img id="uploadPreview" class="w-100 uploadPreview" width="100"
                                src="{{ asset('storage/' . $movie->image_cover) }}" alt="preview">
                        @else
                            <img id="uploadPreview" class="w-100 uploadPreview" width="100" src="/images/placeholder.png"
                                alt="preview">
                        @endif
                    </div>
                    <div class="w-75">
                        <label for="image" class="form-label text-white">Image</label>
                        <input type="file" accept="image/*" class="form-control upload_image" name="image_cover"
                            value="{{ old('image_cover', $apartment->image_cover) }}">
                        @error('image_cover')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div> --}}


                <div class="mb-3 @error('image_cover') @enderror gap-5 img_edit">
                    <div class="w-25">
                        @if ($apartment->image_cover && strpos($apartment->image_cover, 'http') !== false)
                            <img id="uploadPreview" class="w-100 uploadPreview" width="100"
                                src="{{ $apartment->image_cover }}" alt="preview">
                        @elseif ($apartment->image_cover)
                            <img id="uploadPreview" class="w-100 uploadPreview" width="100"
                                src="{{ asset('storage/' . $apartment->image_cover) }}" alt="preview">
                        @else
                            <img id="uploadPreview" class="w-100 uploadPreview" width="100" src="/images/placeholder.png"
                                alt="preview">
                        @endif
                    </div>
                
                    <div class="w-75">
                        <label for="image" class="form-label text-white">Image </label>
                        <input type="file" accept="image/*" class="form-control upload_image" name="image_cover"
                            value="{{ old('image_cover', $apartment->image_cover) }}">
                        @error('image_cover')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <h5>Select services:</h5>
                <div class="mb-3 serv">
                    
                    @foreach ($services as $service)
                    <div>
                        <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input"
                        {{ $apartment->services->contains($service->id) ? 'checked' : ''}}>
                        <label for="" class="form-check-label">{{ $service->name }}</label>
                    </div>
                    @endforeach
                    @error('services')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="alert alert-danger" id="service-error" style="display: none;">Please select at least one service.</div>
                </div>
                <br>
                <div class="text-center w-50 mx-auto d-flex gap-2">
                    <button type="submit" class="mine-custom-btn btn mt-3 w-100">Salva</button>
                    <a href="{{ route('admin.apartments.index') }}"
                        class="btn   ls-btn-2 mt-3 w-100">Indietro</a>
                </div>
            </form>
        </div>
    </section>
    <script>
        //funzione per i service
        document.getElementById('edit-apartment-form').addEventListener('submit', function(event) {
            const serviceCheckboxes = document.querySelectorAll('input[name="services[]"]');
            const serviceError = document.getElementById('service-error');
            let isServiceSelected = false;

            serviceCheckboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    isServiceSelected = true;
                }
            });

            if (!isServiceSelected) {
                serviceError.style.display = 'block';
                event.preventDefault();
            } else {
                serviceError.style.display = 'none';
            }
        });

        //lettura chiave api per la ricerca non tocca 
        window.apiKey = "{{ env('TOMTOM_API_KEY') }}";
    </script>
@endsection
