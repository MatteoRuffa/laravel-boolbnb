@section('title', 'Admin Dashboard / Apartments')
@extends ('layouts.admin')

@section('content')
    <section class="my-5">
        <h1 class=" m-3">All Apartments</h1>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        @include('partials.table-promotions', ['elements' => $promotions, 'elementName' => 'promotion']) 
        {{-- {{$apartments->links('vendor.pagination.bootstrap-5')}}  --}}

       
    </section>
@endsection
