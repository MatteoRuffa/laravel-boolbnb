@section('title', "Admin Dashboard / Apartments ")
@extends('layouts.admin')

@section('content')
    <div class="container ls-glass ls-border p-4">
        
        
        <div class="text-center">
            <img src="{{ asset('storage/' . $apartment->image_cover) }}" alt="{{ $apartment->name }}">
        </div>
            

            <div class="d-flex p-4 mt-5 justify-content-between">
                
                <div id="info-left" class="ls-glass ls-border p-3">
                    
                    <p id="admin-name" >{{ $apartment->name }}</p>

                <ul class="p-2">
                    <li>- Rooms: {{ $apartment->rooms }}</li>
                    <li>- Bathrooms: {{ $apartment->bathrooms }}</li>
                    <li>- Beds: {{ $apartment->beds }}</li>
                    <li>- Square Meters: {{ $apartment->square_meters }}</li>
                </ul>

                <div class="fw-medium fs-5">Address:</div>
                    <p>{{ $apartment->address }}</p>
                    <br>
                    <p>{{ $apartment->latitude }}</p>
                    <br>
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
                    <h4 class="text-center">Informations</h4>
                    {{-- <p>Description: {{ $apartment->description }}</p> --}}
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Doloribus reprehenderit illum, velit, blanditiis laborum quibusdam, ratione nisi eligendi magnam a minima fugiat ex nam inventore excepturi dolorem sit at corrupti libero accusamus voluptate porro aliquam quas quia. Aspernatur eaque saepe dolorum commodi adipisci similique, ducimus quasi temporibus praesentium. At itaque, natus modi quo, eaque perspiciatis consequatur asperiores sed excepturi obcaecati temporibus commodi corporis! Nulla eaque, tempore aliquid natus in odit non expedita quia molestias. Rerum eligendi, veritatis aliquid, id odio unde placeat harum quo sed eaque blanditiis ut, molestias cumque vero iste libero. Incidunt perferendis dolorum quaerat quod itaque nobis voluptate enim ea deserunt cupiditate sit et esse, in eos magnam, est dolorem vero molestias consequatur iure quas expedita. Ipsam consequuntur quae dolore nostrum. Dolorum, omnis ea placeat enim eos accusamus fugit in sapiente incidunt repudiandae officia illum praesentium animi iure corporis eius hic nemo tempore earum id perspiciatis voluptate sequi est? Perspiciatis quod in sed accusantium voluptates autem officia non distinctio iste natus vel rem reprehenderit impedit pariatur, culpa temporibus aut error velit veritatis nostrum enim eius maxime repellendus voluptatibus! Doloribus eveniet mollitia eius nobis, nisi ipsam nemo. Dolor eum debitis doloremque aperiam aliquam accusantium quia eius, nesciunt earum odio reiciendis eligendi tenetur, quam optio quae consectetur suscipit, officiis magni illo enim. Facilis ipsam sequi nobis odio quia consectetur explicabo facere perferendis eveniet, ex voluptatem, repudiandae nulla temporibus. Sunt voluptatem molestias dolores sint minus quae a earum nesciunt perferendis non totam quisquam animi, eaque quia in asperiores facilis sequi maxime corporis consequuntur, eius officia cumque? Fugit voluptates distinctio nulla cum odit laboriosam suscipit impedit itaque perspiciatis nesciunt repellendus voluptatem modi maxime nobis, soluta ad in eos amet deleniti officia ab autem quidem? Eveniet nam adipisci dolorem, cumque obcaecati provident id aperiam corrupti. Ipsa esse fugiat atque delectus soluta amet.</p>
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
                    <button type="button" class="btn btn-danger p-2 mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <a href="{{ route('admin.apartments.index') }}" class="btn ls-btn-2">Back</a>
                </div>
    </div>
@endsection

@include('partials.modal-delete', ['element' => $apartment, 'elementName' => 'apartment'])