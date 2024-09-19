@extends('layouts.main')

@section('title', 'Bem vindo')

@section('content')

    <main>
        {{ $slot }}
    </main>

@endsection
