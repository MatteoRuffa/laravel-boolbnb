@extends('layouts.admin')

@section('title', 'Apartment Details')

@section('content')
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
            <h6 class="fw-bold">Latitude:</h6>
            <p>{{ $apartment->latitude }}</p>
            <h6 class="fw-bold">Longitude:</h6>
            <p>{{ $apartment->longitude }}</p>

            <div class="d-flex p-3 justify-content-between mt-3">
                @if($apartment->services)
                    @foreach ($apartment->services as $service)
                        <div id="ls-badge" class="badge">{{ $service->name }}
                            <img id="ls-icons" src="{{ asset('storage/' . $service->icon) }}" alt="{{ $service->name }}">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div id="info-right" class="ls-border ls-glass p-3">
            <h4 class="text-center text-uppercase mb-4">Sponsorships</h4>
            @if($apartment->promotions->isEmpty())
                <div class="alert alert-warning text-center" role="alert">
                    This apartment has no active promotions.
                </div>
            @else
                @foreach($apartment->promotions as $promotion)
                    <div class="promotion-details mb-3">
                        <h5 class="fw-bold">{{ $promotion->title }}</h5>
                        <p>{{ $promotion->description }}</p>
                        <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($promotion->pivot->start_date)->format('d/m/Y H:i:s') }}</p>
                        <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($promotion->pivot->end_date)->format('d/m/Y H:i:s') }}</p>
                        <p><strong>Remaining Time:</strong> <span id="timer-{{ $apartment->id }}-{{ $promotion->id }}"></span></p>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            function startTimer(duration, display) {
                                var timer = duration, hours, minutes, seconds;
                                setInterval(function () {
                                    hours = parseInt(timer / 3600, 10);
                                    minutes = parseInt((timer % 3600) / 60, 10);
                                    seconds = parseInt(timer % 60, 10);

                                    hours = hours < 10 ? "0" + hours : hours;
                                    minutes = minutes < 10 ? "0" + minutes : minutes;
                                    seconds = seconds < 10 ? "0" + seconds : seconds;

                                    display.textContent = hours + ":" + minutes + ":" + seconds;

                                    if (--timer < 0) {
                                        clearInterval(interval); // Ferma l'intervallo una volta terminato il timer
                                    }
                                }, 1000);
                            }

                            var now = new Date().getTime();
                            var end = new Date('{{ \Carbon\Carbon::parse($promotion->pivot->end_date)->format('Y-m-d H:i:s') }}').getTime();
                            var duration = Math.floor((end - now) / 1000);
                            var display = document.querySelector('#timer-{{ $apartment->id }}-{{ $promotion->id }}');

                            if (duration > 0) {
                                startTimer(duration, display);
                            } else {
                                display.textContent = '00:00:00';
                            }
                        });
                    </script>
                @endforeach
            @endif
        </div>
    </div>
</div>

<!-- Payment Modal -->
<button id="cta-sponsor" class="btn btn-cta mb-4 w-100" data-bs-toggle="modal" data-bs-target="#showPayment">   
    <strong><i class="fa-solid fa-crown me-3 "></i>Attiva la sponsorizzazione</strong>
</button>

<div id="box-payment" class="d-none">
    <div class="modal fade" id="showPayment" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0067697b; color:#4f4f4f">
                    <h1 class="modal-title fs-5">Attiva la sponsorizzazione</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #00676939;">
                    <form id="payment-form" action="{{ route('admin.payment.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
                        <select id="promotion_id" class="form-select mb-3" name="promotion_id" onclick="change(value)">
                            <option value="" disabled selected>Seleziona sponsorizzazione</option>
                            @foreach ($promotions as $promotion)
                                <option class="option" value="{{ $promotion->id }}">{{ $promotion->title }}</option>
                            @endforeach
                        </select>
                        <div id="error-message" class="text-danger d-none">Per favore, scegli una sponsorizzazione.</div>
                        <div id="box-description" class="box-description">
                            @foreach ($promotions as $promotion)
                                <div id="text-description-{{ $promotion->id }}" class="text-hide d-none">
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
</div>

<div class="link d-flex align-items-center justify-content-start p-3">
    <a class="btn ls-btn p-2" href="{{ route('admin.apartments.edit', $apartment->slug) }}">
        <i class="fa-solid fa-gear"></i>
    </a>
    <button type="button" class="btn btn-danger p-2 mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $apartment->id }}">
        <i class="fa-solid fa-trash"></i>
    </button>
    <a href="{{ route('admin.apartments.index') }}" class="btn ls-btn-2">Back</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let form = document.getElementById('payment-form');
        let client_token = "{{ $clientToken }}";

        document.getElementById('promotion_id').selectedIndex = 1;
        change(document.getElementById('promotion_id').value);

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

                const promotionSelect = document.getElementById('promotion_id');
                const errorMessage = document.getElementById('error-message');

                if (promotionSelect.value === "") {
                    errorMessage.classList.remove('d-none');
                    return;
                } else {
                    errorMessage.classList.add('d-none');
                }

                instance.requestPaymentMethod(function (err, payload) {
                    if (err) {
                        console.error(err);
                        return;
                    }

                    let nonceInput = document.createElement('input');
                    nonceInput.name = 'payment_method_nonce';
                    nonceInput.type = 'hidden';
                    nonceInput.value = payload.nonce;
                    form.appendChild(nonceInput);

                    form.submit();
                });
            });
        });

        let btn_sponsor = document.getElementById('cta-sponsor');
        btn_sponsor.addEventListener('click', function() {
            document.getElementById('box-payment').classList.toggle('d-none');
        });
    });

    function change(value) {
        const divs = document.querySelectorAll('.text-hide');
        divs.forEach(div => {
            div.classList.add('d-none');
        });

        document.querySelector('#box-description #text-description-' + value).classList.remove('d-none');
    }
</script>
@endsection
