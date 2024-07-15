@section('title', 'Admin Dashboard / Messages')
@extends('layouts.admin')

@section('content')
    <section class="my-5">
        <h1 class="text-decoration-underline m-3">{{ $lead->name }} has sent you a message</h1>

        <p class="my-3 p-2">
            {{ $lead->message }}
        </p>

        <span>{{ $lead->created_at }}</span>

        <span>You may contact {{ $lead->name }} through the following email: {{ $lead->email }}</span>
    </section>
@endsection
