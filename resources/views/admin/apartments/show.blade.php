@section('title', "Admin Dashboard / Apartments ")
@extends('layouts.admin')

@section('content')
    <div class="container ls-glass ls-border p-4">
        
        
        <div class="text-center">
            <img class="responsive-img img-fluid" src="{{ asset('storage/' . $apartment->image_cover) }}" alt="{{ $apartment->name }}">
        </div>
            

            <div class="d-flex p-4 mt-5 justify-content-between query">
            
                
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
                    {{-- <p>Description: {{ $apartment->description }}</p> --}}
                    <p>{{ $apartment->description }}</p>
                </div>

                

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
            </div>          
                <div class="link d-flex align-items-center justify-content-start p-3">
                    <a class="btn ls-btn p-2" href="{{ route('admin.apartments.edit', $apartment->slug) }}" class="update-link p-4">
                        <i class="fa-solid fa-gear"></i>
                    </a>
                    <button type="button" class="btn btn-danger p-2 mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $apartment->id }}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <a href="{{ route('admin.apartments.index') }}" class="btn ls-btn-2">Back</a>
                </div>
    </div>

    
@endsection

@include('partials.modal-delete', ['element' => $apartment, 'elementName' => 'apartment'])