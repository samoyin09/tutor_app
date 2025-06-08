@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-white">Welcome, {{ Auth::user()->name }}</h1>
    <p class="text-white">This is your student dashboard.</p>
</div>
@endsection
