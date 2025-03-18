@extends('layouts.main')

@section('title', 'Bem vindo')

@section('content')


    <style>
        .content{
            padding-top: 80px 
        }
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        .search-bar {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .search-bar input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .filters {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .filters select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .filters button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .filters button:hover {
            background-color: #0056b3;
        }
        .house-list {
            list-style-type: none;
            padding: 0;
        }
        .house-list li {
            background-color: #f9f9f9;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }
        .house-list li img {
            width: 300px;
            height: 250px;
            margin-right: 20px;
            border-radius: 5px;
            object-fit: cover;
        }
        .house-list li h3 {
            margin: 0;
            font-size: 1.5em;
        }
        .house-list li p {
            margin: 5px 0 0;
            color: #666;
        }
        .house-details {
            flex-grow: 1;
        }
        .house-list li button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .house-list li button:hover {
            background-color: #218838;
        }
    </style>
    <div class="content">


        <h1>Casas Disponíveis</h1>

        <!-- Barra de Pesquisa -->
        <div class="search-bar">
            <input type="text" id="search" placeholder="Pesquisar por nome ou endereço">
        </div>

        <!-- Filtros -->
        <div class="filters">
            <select id="neighborhood-filter">
                <option value="">Filtrar por Bairro</option>
                <option value="bairro1">Alvorada</option>
                <option value="bairro2">Centro</option>
                <option value="bairro3">Vila</option>
                <option value="bairro3">São Geraldo</option>
                <option value="bairro3">São Francisco</option>

            </select>

            <select id="price-filter">
                <option value="">Filtrar por Preço</option>
                <option value="0-500000">Até R$ 750.00</option>
                <option value="500000-750000">De R$ 750.00 a R$ 1500.00</option>
                <option value="750000">Acima de R$ 1500.00</option>
            </select>
            <select id="type_property_filter">
                <option value="">Filtrar por Tipo de Imóvel</option>
                <option value="Casa">Casa</option>
                <option value="Apartamento">Apartamento</option>
                <option value="Comercial">Comercial</option>
            </select>
        </div>

        <div class="filters">
            <button onclick="filterHouses()">Aplicar Filtros</button>
        </div>

        @foreach($propertys as $property)
            <!-- Lista de Casas -->
            <ul class="house-list" id="house-list">
                <li data-city="{{$property->city}}" data-neighborhood="{{$property->neighborhood}}" data-price="{{$property->rental_value}}">
                    <img src="{{ asset('img/casas/' . $property->primary_photo) }}" alt="Foto da Casa">
                        <div class="house-details">
                        <h3>{{$property->property_title}}</h3>
                        <p>Endereço: {{$property->street}}, {{$property->number}}</p>
                        <p>Preço: R$ {{ number_format($property->rental_value, 2, ',', '.') }}</p>
                        <p>Cidade: {{$property->city}}, Bairro: {{$property->neighborhood}}</p>
                    </div>

                        <a href="{{ route('casa', $property->id) }}" class="btn">Saber mais</a>


                </li>
        @endforeach

    

