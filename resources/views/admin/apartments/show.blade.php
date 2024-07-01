@section('title', "Admin Dashboard / Apartments ")
@extends('layouts.admin')



@section('content')
    <div class="container show">
        <div class=" p-3">
            <div class="img-show p-3">
                <img src="{{ asset('storage/' . $apartment->image_cover) }}" alt="{{ $apartment->name }}">
            </div>
            <div class="info p-3 d-flex flex-column">
                <h1>{{ $apartment->name }}</h1>
                <p>Description: {{ $apartment->description }}</p>
                <div>
                    <ul class="p-2">
                        <div class="fw-medium fs-5">Structure details:</div>   
                        <li>rooms: {{ $apartment->rooms }}</li>
                        <li>bathrooms: {{ $apartment->bathrooms }}</li>
                        <li>beds: {{ $apartment->beds }}</li>
                        <li>square_meters: {{ $apartment->square_meters }}</li>
                    </ul>
                    <div  class="fw-medium fs-5">Address: 
                        <p>{{ $apartment->address }}</p> 
                    </div>
                </div>
                <div class="link d-flex align-items-center justify-content-start p-3">
                    <a href="{{ route('admin.apartments.edit',$apartment->slug) }}" class="update-link p-4">
                        <i class="fa-solid fa-gear"></i>
                    </a>
                    <button type="button" class="btn btn-danger px-3 mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <a href="{{ route('admin.apartments.index') }}"
                        class="btn ">Back
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('partials.modal-delete',  ['element' => $apartment, 'elementName' => 'apartment']) 