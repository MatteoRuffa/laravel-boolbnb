@section('title', 'Admin Dashboard / Apartments')
@extends ('layouts.admin')

@section('content')
    <section class="my-5">
        <h1 class="text-decoration-underline m-3">Total apartments: {{ $totalApartments }}</h1>
        <a role="button" class="btn draw-border m-3" href="{{ route('admin.apartments.create') }}"><i class="fa-solid fa-plus"></i> Add a Apartment</a> 
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        @include('partials.table-apartments', ['elements' => $apartments, 'elementName' => 'apartment'])
        {{$apartments->links('vendor.pagination.bootstrap-5')}} 
        
    </section>
@endsection 




