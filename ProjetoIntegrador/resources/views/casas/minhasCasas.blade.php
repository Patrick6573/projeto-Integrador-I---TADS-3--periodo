@extends('layouts.main')

@section('title', 'Minhas Casas')

@section('content')

<h1 style="font-size: 36px; font-weight: bold; color: #333; margin-bottom: 20px; text-align:left; padding-top: 20px; margin: 2px;">
    Minhas Casas
</h1>

@if($properties->isEmpty())
    <p style="text-align: left; font-size: 18px; color: #666;">Você ainda não possui nenhuma casa anunciada.</p>
@else
    @foreach($properties as $property)
        <div class="house-details-container" style="display: flex; flex-direction: row; gap: 20px; padding: 20px; width: 100%; margin: 20px 0; align-items: flex-start; justify-content: flex-start; background-color: #f8f9fa; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <!-- Imagem da Casa -->
            <div class="house-image">
                <img src="{{ asset('img/casas/' . $property->primary_photo) }}" alt="Foto da Casa" style="width: 400px; height: auto; border-radius: 8px;">
            </div>
            <!-- Detalhes da Casa -->
            <div class="house-info" style="text-align: left;">
                <h2 style="font-size: 24px; font-weight: bold;">{{ $property->property_title }}</h2>
                <p><strong>Endereço:</strong> {{ $property->street }}, {{ $property->number }}</p>
                <p><strong>Bairro:</strong> {{ $property->neighborhood }}</p>
                <p><strong>Cidade:</strong> {{ $property->city }} - {{ $property->state }}</p>
                <p><strong>Preço:</strong> R$ {{ number_format($property->rental_value, 2, ',', '.') }}</p>
                <p><strong>Descrição:</strong> {{ $property->property_description }}</p>
                <p><strong>Tipo:</strong> {{ $property->property_type }}</p>
                <p><strong>Tamanho:</strong> {{ $property->property_size }} m²</p>
                <p><strong>Ponto de Referência:</strong> {{ $property->reference_point }}</p>
                <p><strong>Complemento:</strong> {{ $property->complement }}</p>
                
                <!-- Outros detalhes da casa -->
                <p><strong>Quartos:</strong> {{ $property->number_rooms }}</p>
                <p><strong>Banheiros:</strong> {{ $property->number_bathrooms }}</p>

                <!-- Botões de Ação -->
                <div class="house-actions" style="margin-top: 20px;">
                    <a href="{{ route('property.edit', $property->id) }}" style="padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; text-decoration: none;">
                        Editar Anúncio
                    </a>
                    <form action="{{ route('property.delete', $property->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="padding: 10px 20px; background-color: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer;">
                            Retirar Anúncio
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endif


@endsection
