@section('title', 'Admin Dashboard / Apartments')
@extends('layouts.admin')


@section('content')
    <section class="container py-5">


        <div class="container">
            <h1 class=" fw-bolder text-center ">Add a Apartment</h1>
            
            <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                
                
                <div class="mb-3 @error('name') @enderror">
                        <label for="name" class="form-label fs-5 fw-medium">name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ old('name') }}" required maxlength="255" >
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
                    <label for="rooms" class="form-label fs-5 fw-medium">Stanze</label>
                    <input type="number" class="form-control @error('rooms') is-invalid @enderror"
                        id="rooms" name="rooms" value="{{ old('rooms') }}" required>
                    @error('rooms')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('beds') @enderror">
                    <label for="beds" class="form-label fs-5 fw-medium">Letti</label>
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
                        id="square_meters" name="square_meters" value="{{ old('square_meters') }}" required maxlength="255" minlength="3">
                    @error('square_meters')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="address">
                    <div class="mb-3 @error('streetName') @enderror">
                        <label for="streetName" class="form-label fs-5 fw-medium">Street name</label>
                        <input class="form-control @error('streetName') is-invalid @enderror" type="text" id="streetName" name="streetName" value="{{ old('streetName') }}" required>
                        @error('streetName')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                        <div class="mb-3 @error('houseNumber') @enderror">
                        <label for="houseNumber" class="form-label fs-5 fw-medium">House number</label>
                        <input class="form-control @error('houseNumber') is-invalid @enderror" type="number" id="houseNumber" name="houseNumber" value="{{ old('houseNumber') }}" required>
                        @error('houseNumber')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 @error('city') @enderror">
                        <label for="city" class="form-label fs-5 fw-medium">City</label>
                        <input class="form-control @error('city') is-invalid @enderror" type="text" id="city" name="city" value="{{ old('city') }}" required>
                        @error('city')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 @error('cap') @enderror">
                        <label for="cap" class="form-label fs-5 fw-medium">Cap</label>
                        <input class="form-control @error('cap') is-invalid @enderror" type="number" id="cap" name="cap" value="{{ old('cap') }}" required>
                        @error('cap')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
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

                    <div class="text-center w-25 mx-auto d-flex gap-2">
                        <button type="submit" class="btn ">Add the Apartment</button>
                        <a href="{{ route('admin.apartments.index') }}"
                            class="btn ">Back
                        </a>
                    </div> 
            </form>
        </div>

    </section>
@endsection