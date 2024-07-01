@section('title', 'Edit Apartments {{ $apartment->name }}')
@extends('layouts.admin')

@section('content')
    <section class="container py-5">
        <div class="container rounded-2 p-5 container-table">
            <h1 class="text-center text-white fw-bolder">Modify apartment: {{ $apartment->title }}</h1>

            <form id="comic-form" action="{{ route('admin.apartments.update', $apartment->slug) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                @method('PUT')
                <div class="mb-3 @error('name') @enderror">
                    <label for="name" class="form-label fs-5 fw-medium">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name', $apartment->name) }}" required maxlength="255"
                        minlength="3">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('description') @enderror">
                    <label for="description" class="form-label fs-5 fw-medium">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description" >{{ old('description',  $apartment->beds) }}</textarea>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('rooms') @enderror">
                    <label for="rooms" class="form-label fs-5 fw-medium">Rooms</label>
                    <input type="number" class="form-control @error('rooms') is-invalid @enderror"
                        id="rooms" name="rooms" value="{{ old('rooms', $apartment->rooms) }}">
                    @error('rooms')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('beds') @enderror">
                    <label for="beds" class="form-label fs-5 fw-medium">Beds</label>
                    <input type="number"
                        class="form-control @error('beds') is-invalid @enderror"
                        id="beds" name="beds"
                        value="{{ old('beds', $apartment->beds) }}" required maxlength="255"
                        minlength="3">
                    @error('beds')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('bathrooms') @enderror">
                    <label for="bathrooms" class="form-label fs-5 fw-medium">Bathrooms</label>
                    <input type="number" class="form-control @error('bathrooms') is-invalid @enderror" id="bathrooms" name="bathrooms"
                        >{{ old('bathrooms', $apartment->bathrooms) }}
                    @error('bathrooms')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('square_meters') @enderror">
                    <label for="square_meters" class="form-label fs-5 fw-medium">Square meters</label>
                    <input type="number" class="form-control @error('square_meters') is-invalid @enderror" id="square_meters" name="square_meters"
                        >{{ old('square_meters', $apartment->square_meters) }}
                    @error('square_meters')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 @error('address') @enderror">
                    <label for="address" class="form-label fs-5 fw-medium">Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address">
                    {{ old('address', $apartment->address) }}
                    @error('address')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
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


                <div class="mb-3 @error('image_cover') @enderror d-flex gap-5 align-items-center">
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
                        <label for="image" class="form-label text-white">Immagine </label>
                        <input type="file" accept="image/*" class="form-control upload_image" name="image_cover"
                            value="{{ old('image_cover', $apartment->image_cover) }}">
                        @error('image_cover')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <br>
                <div class="text-center w-50 mx-auto d-flex gap-2">
                    <button type="submit" class="mine-custom-btn mt-3 w-100">Salva</button>
                    <a href="{{ route('admin.apartments.index') }}"
                        class="mine-custom-btn min-custom-btn-grey mt-3 w-100">Indietro</a>
                </div>
            </form>
        </div>

    </section>
@endsection
