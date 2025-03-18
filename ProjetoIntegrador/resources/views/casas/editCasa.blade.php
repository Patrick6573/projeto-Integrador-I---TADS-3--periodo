

@extends('layouts.main')

@section('title', 'Editar Casa')

@section('content')

<h1 style="font-size: 36px; font-weight: bold; color: #333; margin-bottom: 20px; text-align:center">
    Editar Casa: {{ $property->property_title }}
</h1>

<div class="edit-house-container" style="max-width: 800px; margin: 0 auto; padding: 20px; background-color: #f8f9fa; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <form action="{{ route('casas.update', $property->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group" style="margin-bottom: 15px;">
            <label for="property_title">Título da Casa:</label>
            <input type="text" id="property_title" name="property_title" value="{{ $property->property_title }}" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label for="street">Endereço:</label>
            <input type="text" id="street" name="street" value="{{ $property->street }}" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label for="number">Número:</label>
            <input type="text" id="number" name="number" value="{{ $property->number }}" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label for="neighborhood">Bairro:</label>
            <input type="text" id="neighborhood" name="neighborhood" value="{{ $property->neighborhood }}" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label for="city">Cidade:</label>
            <input type="text" id="city" name="city" value="{{ $property->city }}" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label for="state">Estado:</label>
            <input type="text" id="state" name="state" value="{{ $property->state }}" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label for="rental_value">Preço:</label>
            <input type="number" id="rental_value" name="rental_value" value="{{ $property->rental_value }}" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label for="property_size">Tamanho (m²):</label>
            <input type="number" id="property_size" name="property_size" value="{{ $property->property_size }}" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label for="description">Descrição:</label>
            <textarea id="description" name="description" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">{{ $property->description }}</textarea>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="photos">Fotos (opcional):</label>
            <input type="file" id="photos" name="photos[]" multiple style="width: 100%;">
        </div>

        <div class="form-actions" style="text-align: center;">
            <button type="submit" style="padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Atualizar Casa
            </button>
            <a href="{{ route('minhasCasas') }}" style="padding: 10px 20px; background-color: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection



