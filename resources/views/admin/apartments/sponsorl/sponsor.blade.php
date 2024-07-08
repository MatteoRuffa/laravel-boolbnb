@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crea una Sponsorizzazione per {{ $apartment->name }}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.sponsor.store', ['apartment' => $apartment->slug]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="promotion_id">promotion</label>
            <select name="promotion_id" id="promotion_id" class="form-control">
                @foreach($promotions as $promotion)
                    <option value="{{ $promotion->id }}">
                        {{ $promotion->title }} - €{{ $promotion->price }} - {{ $promotion->duration }} ore
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="apartment_id">Appartamento</label>
            <select name="apartment_id" id="apartment_id" class="form-control">
                @foreach($apartments as $apart)
                    <option value="{{ $apart->id }}">
                        {{ $apart->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Crea Sponsorizzazione</button>
        <a class="btn my_btn" href="{{ route('admin.sponsor.show', $apartment->slug) }}">le tue sponsorizzazioni</a>



    </form>
</div>
@endsection