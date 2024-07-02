@section('title', 'Admin Dashboard / Apartments')
@extends('layouts.admin')


@section('content')
    <section class="container py-5">


        <div class="container">
            <h1 class=" fw-bolder text-center ">Add a Apartment</h1>
            
            <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data" id="create-apartment-form">
                @csrf
                
                
                <div class="mb-3 @error('name') @enderror">
                        <label for="name" class="form-label fs-5 fw-medium">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ old('name') }}" required maxlength="255" minlength="3">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                <div class="mb-3 @error('description') @enderror">
                    <label for="description" class="form-label fs-5 fw-medium">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description" style="min-height: 300px">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('rooms') @enderror">
                    <label for="rooms" class="form-label fs-5 fw-medium">Rooms</label>
                    <input type="number" class="form-control @error('rooms') is-invalid @enderror"
                        id="rooms" name="rooms" value="{{ old('rooms') }}" required>
                    @error('rooms')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('beds') @enderror">
                    <label for="beds" class="form-label fs-5 fw-medium">Beds</label>
                    <input type="number" class="form-control @error('beds') is-invalid @enderror"
                        id="beds" name="beds" value="{{ old('beds') }}" required>
                    @error('beds')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('square_meters') @enderror">
                    <label for="bathrooms"  class="form-label fs-5 fw-medium">Bathrooms</label>
                    <input type="number" class="form-control @error('beds') is-invalid @enderror" id="bathrooms" name="bathrooms" value="{{ old('bathrooms') }}" required>
                    @error('bathrooms')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('square_meters') @enderror">
                    <label for="square_meters" class="form-label fs-5 fw-medium">Square meters</label>
                    <input type="text" class="form-control @error('square_meters') is-invalid @enderror"
                        id="square_meters" name="square_meters" value="{{ old('square_meters') }}" required maxlength="255" minlength="2">
                    @error('square_meters')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="address">
                    <div class="mb-3 @error('address') @enderror">
                        <label for="address" class="form-label fs-5 fw-medium">Address</label>
                        <input class="form-control @error('address') is-invalid @enderror" type="text" id="address" name="address" value="{{ old('address') }}" required maxlength="255" minlength="7">
                        @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <select id="resultsSelect" class="form-control mt-2" style="display: none;"></select>    
                </div>


                <div class="mb-3 @error('image_cover') @enderror d-flex gap-5 align-items-center">
                    <div class="w-25 text-center">
                            <img id="uploadPreview" class="w-100" width="100"
                                src="{{asset('image/placeholder.png')}}">
                        </div>
                        <div class="w-75">
                            <label for="image_cover" class="form-label fs-5 fw-medium">Image</label>
                            <input type="file" accept="image/*"
                                class="form-control @error('image_cover') is-invalid @enderror" id="uploadImage"
                                name="image_cover" value="{{ old('image_cover') }}" required maxlength="255">
                            @error('image_cover')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> 
                    
                    <div class="mb-3">
                        <p>Select service:</p>
                        @foreach ($services as $service)
                        <div>
                            <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input"
                                {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}>
                            <label for="" class="form-check-label">{{ $service->name }}</label>
                        </div>
                        @endforeach
                        <div class="alert alert-danger" id="service-error" style="display: none;">Please select at least one service.</div>
                    </div>

                    <div class="text-center w-25 mx-auto d-flex gap-2">
                        <button type="submit" class="btn ">Add the Apartment</button>
                        <a href="{{ route('admin.apartments.index') }}"
                            class="btn ">Back
                        </a>
                    </div> 
            </form>
        </div>
    </section>
    <script>
        //funzione per i service
        document.getElementById('create-apartment-form').addEventListener('submit', function(event) {
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
        //funzione api indirizzo
        document.addEventListener('DOMContentLoaded', function() {
        const addressInput = document.getElementById('address');
        const resultsSelect = document.getElementById('resultsSelect');
        const apiKey= 'pqIYPfZIN1ji4KwqY0UAXNvwMpSdx2GH';
        const apiBaseUrl= 'https://api.tomtom.com/search/2/search/';
        const fetchAddresses = (query) => {
            return fetch(`${apiBaseUrl}${query}.json?key=${apiKey}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => data.results)
                .catch(error => {
                    console.error('Error fetching the address:', error);
                    return [];
                });
        };

        const updateResults = (results) => {
            resultsSelect.innerHTML = '';
            if (results.length > 0) {
                resultsSelect.style.display = 'block';
                results.forEach(result => {
                    const option = document.createElement('option');
                    option.value = result.address.freeformAddress;
                    option.textContent = result.address.freeformAddress;
                    resultsSelect.appendChild(option);
                });
            } else {
                resultsSelect.style.display = 'none';
            }
        };
        addressInput.addEventListener('input', async function() {
            const query = addressInput.value;
            if (query.length < 5) {
                resultsSelect.style.display = 'none';
                resultsSelect.innerHTML = '';
                return;
            }
            const results = await fetchAddresses(query);
            updateResults(results);
        });

        resultsSelect.addEventListener('change', function() {
            addressInput.value = resultsSelect.value;
            resultsSelect.style.display = 'none';
        });

    });
    </script>
@endsection






