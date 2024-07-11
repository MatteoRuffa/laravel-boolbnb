@section('title', "Admin Dashboard / Apartments")
@extends('layouts.admin')

@section('content')
<title>Apartment Details</title>
<script src="https://js.braintreegateway.com/web/dropin/1.30.1/js/dropin.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://js.braintreegateway.com/web/3.89.1/js/client.min.js"></script>

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
    </div>

    <!-- MODALE DI PAGAMENTO -->
    <button id="cta-sponsor" class="btn btn-cta mb-4 w-100" data-bs-toggle="modal" data-bs-target="#showPayment">
        <strong><i class="fa-solid fa-crown me-3"></i>Attiva la sponsorizzazione</strong>
    </button>

    <div class="modal fade" id="showPayment" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0067697b; color:#4f4f4f">
                    <h1 class="modal-title fs-5">Attiva la sponsorizzazione</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #00676939;">
                    <form id="payment-form" action="{{ route('admin.payment.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
                        <select id="promotion_id" class="form-select mb-3" name="promotion_id" onchange="change(this.value)">
                            <option value="" disabled selected>Seleziona sponsorizzazione</option>
                            @foreach ($promotions as $promotion)
                                <option class="option" value="{{ $promotion->id }}">{{ $promotion->title }}</option>
                            @endforeach
                        </select>
                        <div id="error-message" class="text-danger d-none">Per favore, scegli una sponsorizzazione.</div>

                        <div id="box-description" class="box-description">
                            @foreach ($promotions as $index => $promotion)
                                <div id="text-description-{{ $index + 1 }}" class="text-hide d-none">
                                    <strong>Costo</strong>: {{ $promotion->price }}€ <br>
                                    <strong>Durata</strong>: {{ $promotion->duration }} ore <br>
                                    {{ $promotion->description }}
                                </div>
                            @endforeach
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
    <!-- FINE MODALE DI PAGAMENTO -->

    <div class="link d-flex align-items-center justify-content-start p-3">
        <a class="btn draw-border" href="{{ route('admin.apartments.edit', $apartment->slug) }}">
            <i class="fa-solid fa-gear"></i> Settings
        </a>
        <button type="button" class="btn draw-border mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $apartment->id }}">
            <i class="fa-solid fa-trash"></i> Delete
        </button>
        <a href="{{ route('admin.apartments.index') }}" class="btn draw-border">
            <i class="fa-solid fa-chevron-left"></i> Go back
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let form = document.getElementById('payment-form');
        let client_token = "{{ $clientToken }}"; // Token per Braintree

        // Seleziona la prima opzione come predefinita e mostra la descrizione
        document.getElementById('promotion_id').selectedIndex = 1; // Seleziona la prima sponsorizzazione valida
        change(document.getElementById('promotion_id').value); // Chiamata alla funzione change per mostrare la descrizione

        braintree.dropin.create({
            authorization: client_token,
            container: '#dropin-container'
        }, function (createErr, instance) {
            if (createErr) {
                console.error(createErr);
                return;
            }

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                // Validazione: assicurarsi che una sponsorizzazione sia selezionata
                const promotionSelect = document.getElementById('promotion_id');
                const errorMessage = document.getElementById('error-message');

                if (promotionSelect.value === "") {
                    errorMessage.classList.remove('d-none'); // Mostra il messaggio di errore se nessuna sponsorizzazione è selezionata
                    return;
                } else {
                    errorMessage.classList.add('d-none'); // Nasconde il messaggio di errore se una sponsorizzazione è selezionata
                }

                instance.requestPaymentMethod(function (err, payload) {
                    if (err) {
                        console.error(err);
                        return;
                    }

                    let nonceInput = document.createElement('input');
                    nonceInput.name = 'payment_method_nonce';
                    nonceInput.type = 'hidden';
                    nonceInput.value = payload.nonce; // Aggiunge il nonce al form
                    form.appendChild(nonceInput);

                    form.submit(); // Invia il form
                });
            });
        });

        // Gestisce il clic sul pulsante per mostrare/nascondere il box dei pagamenti
        let btn_sponsor = document.getElementById('cta-sponsor');
        btn_sponsor.addEventListener('click', function () {
            document.getElementById('box-payment').classList.toggle('d-none'); // Mostra/nasconde il box
        });
    });

    function change(value) {
        console.log(value);

        const divs = document.querySelectorAll('.text-hide');
        divs.forEach(div => {
            div.classList.add('d-none'); // Nasconde tutte le descrizioni delle promozioni
        });

        const targetDiv = document.querySelector('#box-description #text-description-' + value);
        if (targetDiv) { // Verifica se l'elemento target esiste
            targetDiv.classList.remove('d-none'); // Mostra la descrizione della promozione selezionata
        }
    }
</script>

@endsection

@include('partials.modal-delete', ['element' => $apartment, 'elementName' => 'apartment'])
