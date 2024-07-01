@section('title', "Admin Dashboard / Apartments ")
@extends('layouts.admin')

@section('content')
    <div class="container show">
        <div class="p-3">
            <div class="img-show p-3">
                <img src="{{ asset('storage/' . $apartment->image_cover) }}" alt="{{ $apartment->name }}">
            </div>
            <div class="info p-3 d-flex flex-column">
                <h1>{{ $apartment->name }}</h1>
                <p>Description: {{ $apartment->description }}</p>
                <ul class="p-2">
                    <li>Rooms: {{ $apartment->rooms }}</li>
                    <li>Bathrooms: {{ $apartment->bathrooms }}</li>
                    <li>Beds: {{ $apartment->beds }}</li>
                    <li>Square Meters: {{ $apartment->square_meters }}</li>
                </ul>
                <div class="fw-medium fs-5">Address:</div>
                <p>{{ $apartment->address }}</p>

                {{-- @if ($apartment->isPromoted())
                    <div class="alert alert-info mt-3">
                        Questo appartamento è sponsorizzato fino al {{ $apartment->currentPromotion()->pivot->end_date->format('d-m-Y H:i') }} ({{ $apartment->currentPromotion()->pivot->end_date->diffForHumans() }} rimanenti).
                    </div>
                @else
                    <form action="{{ route('admin.apartments.promote', $apartment) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="promotion_id" class="form-label">Seleziona un pacchetto di sponsorizzazione:</label>
                            <select class="form-select" id="promotion_id" name="promotion_id" required>
                                @foreach ($promotions as $promotion)
                                    <option value="{{ $promotion->id }}">{{ $promotion->title }} - {{ $promotion->price }} € per {{ $promotion->duration }} ore</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Sponsorizza</button>
                    </form>
                @endif --}}

                <div class="link d-flex align-items-center justify-content-start p-3">
                    <a href="{{ route('admin.apartments.edit', $apartment->slug) }}" class="update-link p-4">
                        <i class="fa-solid fa-gear"></i>
                    </a>
                    <button type="button" class="btn btn-danger px-3 mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <a href="{{ route('admin.apartments.index') }}" class="btn">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('partials.modal-delete', ['element' => $apartment, 'elementName' => 'apartment'])