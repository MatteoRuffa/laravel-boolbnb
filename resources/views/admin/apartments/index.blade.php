@section('title', 'Admin Dashboard / Apartments')
@extends ('layouts.admin')

@section('content')
    <section class="my-5">
        <h1 class=" m-3">All Apartments</h1>
        <a role="button" class="btn btn-add mb-3" href="{{ route('admin.apartments.create') }}">Add a Apartment</a> 
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        @include('partials.table-apartments', ['elements' => $apartments, 'elementName' => 'apartment'])
        {{$apartments->links('vendor.pagination.bootstrap-5')}} 
        
    </section>
@endsection 




