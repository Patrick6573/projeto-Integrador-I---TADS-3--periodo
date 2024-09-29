@extends('layouts.main')

@section('title', 'Bem-vindo')

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container mt-5">
    <h3 class="text-center mb-4">Cadastro de Casas</h3>
<<<<<<< Updated upstream
    <form action="/cadastroCasa" method="POST" class="shadow p-4 rounded bg-light mx-auto" style="max-width: 600px;" enctype="multipart/form-data">
=======
    <form action="/cadastroCasa" method="POST" class="shadow p-4 rounded bg-light mx-auto" style="max-width: 600px;">
>>>>>>> Stashed changes
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="street">Logradouro</label>
            <input type="text" class="form-control form-control-sm" id="street" name="street" maxlength="50" placeholder="Ex: Rua das Flores" required>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="number">Número</label>
                <input type="number" class="form-control form-control-sm" id="number" name="number" placeholder="Ex: 123" required>
            </div>
            <div class="form-group col-md-6">
                <label for="zip_code">CEP</label>
                <input type="text" class="form-control form-control-sm" id="zip_code" name="zip_code" maxlength="20" placeholder="Ex: 12345-678" required pattern="\d{5}-\d{3}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="city">Cidade</label>
                <input type="text" class="form-control form-control-sm" id="city" name="city" maxlength="50" placeholder="Ex: São Paulo" required>
            </div>
            <div class="form-group col-md-6">
                <label for="state">Estado</label>
                <input type="text" class="form-control form-control-sm" id="state" name="state" maxlength="20" placeholder="Ex: SP" required>
            </div>
        </div>

        <div class="form-group">
            <label for="complement">Complemento</label>
            <input type="text" class="form-control form-control-sm" id="complement" name="complement" maxlength="50" placeholder="Ex: Apto 101">
        </div>

        <div class="form-group">
            <label for="reference_point">Ponto de Referência</label>
            <input type="text" class="form-control form-control-sm" id="reference_point" name="reference_point" maxlength="50" placeholder="Ex: Próximo ao mercado">
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="number_rooms">Número de Quartos</label>
                <input type="number" class="form-control form-control-sm" id="number_rooms" name="number_rooms" placeholder="Ex: 3" required>
            </div>
            <div class="form-group col-md-6">
                <label for="number_bathrooms">Número de Banheiros</label>
                <input type="number" class="form-control form-control-sm" id="number_bathrooms" name="number_bathrooms" placeholder="Ex: 2" required>
            </div>
        </div>

        <div class="form-group">
            <label for="property_size">Tamanho do Imóvel (m²)</label>
            <input type="number" class="form-control form-control-sm" id="property_size" name="property_size" placeholder="Ex: 100" required>
        </div>

        <div class="form-group">
            <label for="rental_value">Valor de Aluguel</label>
            <input type="number" class="form-control form-control-sm" id="rental_value" name="rental_value" step="0.01" placeholder="Ex: 1500.00" required>
        </div>

        <div class="form-group">
            <label for="property_description">Descrição do Imóvel</label>
            <textarea class="form-control form-control-sm" id="property_description" name="property_description" maxlength="500" placeholder="Descreva o imóvel..."></textarea>
        </div>

        <div class="form-group">
            <label for="property_type">Tipo de Imóvel</label>
            <input type="text" class="form-control form-control-sm" id="property_type" name="property_type" maxlength="50" placeholder="Ex: Apartamento" required>
        </div>

        <div class="form-group">
            <label for="property_status">Status do Imóvel</label>
            <input type="text" class="form-control form-control-sm" id="property_status" name="property_status" maxlength="50" placeholder="Ex: Disponível" required>
        </div>

        <div class="form-group">
            <label for="property_title">Título do Imóvel</label>
            <input type="text" class="form-control form-control-sm" id="property_title" name="property_title" maxlength="50" placeholder="Ex: Linda Casa de Praia">
        </div>
        
        <div class="form-group">
            <label for="image">Foto Primária:</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
        </div>

        <div class="form-group">
            <label for="secondary-images">Fotos Secundárias:</label>
            <input type="file" class="form-control-file" id="secondary-images" name="images[]" multiple accept="image/*">
        </div>

        <div class="form-group">
            <label for="videos">Vídeos:</label>
            <input type="file" class="form-control-file" id="videos" name="videos[]" multiple accept="video/*">
        </div>

        <button type="submit" class="btn btn-primary btn-block">Enviar</button>
    </form>
</div>
@endsection
