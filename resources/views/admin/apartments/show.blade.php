@extends('layouts.admin')

@section('title', "Admin Dashboard / Apartments")

@section('content')

    <title>Apartment Details</title>
    <script src="https://js.braintreegateway.com/web/dropin/1.30.1/js/dropin.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<div class="container my-1 ls-glass ls-border p-4">
    <div class="text-center img-show">
        <img src="{{ asset('storage/' . $apartment->image_cover) }}" alt="{{ $apartment->name }}">
    </div>

    <div class="d-flex p-4 mt-5 justify-content-between">
        <div id="info-left" class="ls-glass ls-border p-3">
            <h4 class="text-center text-uppercase mb-4">Information</h4>
            <h3 class="fw-bold">{{ $apartment->name }}</h3>

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

            <div class="d-flex p-3 justify-content-between mt-3">
                <div id="ls-badges-container">
                    @if($apartment->services)
                        @foreach ($apartment->services as $service)
                            <div id="ls-badge" class="badge">{{ $service->name }}
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

        <div class="col-12 col-md-12 col-lg-4  text-white" >



<button id="cta-sponsor" class="btn btn-cta mb-4 w-100" data-bs-toggle="modal"
data-bs-target="#showPayment"
>
    <strong><i class="fa-solid fa-crown me-3 "></i>Attiva la sponsorizzazione</strong>
</button>

<div id="box-payment" class="d-none">

    {{-- <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal"
    data-bs-target="#showPayment">
        Attiva
    </button> --}}

    <div class="modal fade" id="showPayment" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #0067697b; color:#4f4f4f">
                    <h1 class="modal-title fs-5">Attiva la sponsorizzazione</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #00676939;">
                    <form id="payment-form" action="{{ route('admin.payment.process') }}"  method="POST">
                        @csrf
                        <input type="hidden"  name="apartment_id" value="{{ $apartment->id }}">
                        <select id="promotion_id" class="form-select mb-3"  name="promotion_id" onclick="change(value)">
                            <option >Seleziona sponsorizzazione</option>
                            @foreach ($promotions as $promotion)
                            <option  class="option" value="{{$promotion->id}}">{{$promotion->title}}</option>
            
                            @endforeach
    
                        </select>
    
                        <div id="box-description" class="box-description" >
    
    
                            <div id="text-description-1" class="text-hide d-none ">
                                <strong>Costo</strong>: {{$promotions[0]->price}}€ <br>
                                <strong>Durata</strong>: 24 ore <br>
                                {{$promotions[0]->description}}
                            </div>
                            <div id="text-description-2" class="text-hide d-none">
                                <strong>Costo</strong>: {{$promotions[1]->price}}€ <br>
                                <strong>Durata</strong>: 48 ore <br>
                                {{$promotions[1]->description}}
                            </div>
                            <div id="text-description-3" class="text-hide d-none">
                                <strong>Costo</strong>: {{$promotions[2]->price}}€ <br>
                                <strong>Durata</strong>: 144 ore <br>
                                {{$promotions[2]->description}}
                            </div>
                            
                
                        </div>
    
                        
                        <div id="dropin-container"></div>
    
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-payment fw-bold my-2">Acquista</button>
    
                        </div>
    
                    </form>
                            
                        </div>
                    </div>
                 </div>

            </div>
        </div>
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

<script>
    var clientToken = "{{ $clientToken }}";

    braintree.dropin.create({
        authorization: clientToken,
        container: '#dropin-container'
    }, function (createErr, instance) {
        document.getElementById('submit-button').addEventListener('click', function () {
            instance.requestPaymentMethod(function (err, payload) {
                // Invia payload.nonce al tuo server
            });
        });
    });
</script>
@endsection

@include('partials.modal-delete', ['element' => $apartment, 'elementName' => 'apartment'])
