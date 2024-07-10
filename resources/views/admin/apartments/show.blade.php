@section('title', "Admin Dashboard / Apartments ")
@extends('layouts.admin')

@section('content')
    <div class="container my-1 ls-glass ls-border p-4">
        <div class="text-center img-show">
            <img src="{{ asset('storage/' . $apartment->image_cover) }}" alt="{{ $apartment->name }}">
        </div>
            <div class="d-flex p-4 mt-5 justify-content-between">
                <div id="info-left" class="ls-glass ls-border p-3">
                <h4 class="text-center text-uppercase mb-4">Information</h4>
                    <h3 class="fw-bold" >{{ $apartment->name }}</h3>
                <ul class="p-2">
                    <li><i class="fa-solid fa-home"></i> Rooms: {{ $apartment->rooms }}</li>
                    <li><i class="fa-solid fa-bath"></i> Bathrooms: {{ $apartment->bathrooms }}</li>
                    <li><i class="fa-solid fa-bed"></i> Beds: {{ $apartment->beds }}</li>
                    <li><i class="fa-solid fa-ruler"></i> Square Meters: {{ $apartment->square_meters }}</li>
                </ul>
                <h6 class="fw-bold">Address:</h6>
                    <p>{{ $apartment->address }}</p>
                    <br>
                    <h6 class="fw-bold">Latitude:</h6>
                    <p>{{ $apartment->latitude }}</p>
                    <br>
                    <h6 class="fw-bold">Longitude:</h6>
                    <p>{{ $apartment->longitude }}</p>
                    <div  class="d-flex p-3 justify-content-between mt-3">
                        <div id="ls-badges-container">
                            @if($apartment->services)
                            @foreach ($apartment->services as $service)
                                <div id="ls-badge" class="badge">{{$service->name}}
                                    <img id="ls-icons" src="{{ asset('storage/' . $service->icon) }}" alt="{{ $service->name }}">
                                </div>
                            @endforeach
                        @endif
                        </div>
                    </div>
                </div>
                <div id="info-right" class="ls-border ls-glass p-3">
                    <h4 class="text-center text-uppercase mb-4">Description</h4>
                    <p>{{ $apartment->description }}</p>
                </div>
            </div>          
                <div class="link d-flex align-items-center justify-content-start p-3">
                    <a class="btn draw-border" href="{{ route('admin.apartments.edit', $apartment->slug) }}" class="update-link p-4">
                        <i class="fa-solid fa-gear"></i> Settings
                    </a>
                    <button type="button" class="btn draw-border mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $apartment->id }}">
                        <i class="fa-solid fa-trash"></i> Delete
                    </button>
                    <a href="{{ route('admin.apartments.index') }}" class="btn draw-border"><i class="fa-solid fa-chevron-left"></i> Go back</a>
                </div>
    </div>
@endsection

@include('partials.modal-delete', ['element' => $apartment, 'elementName' => 'apartment'])