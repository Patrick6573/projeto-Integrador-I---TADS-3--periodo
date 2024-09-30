@extends('layouts.main')

@section('title', 'Bem vindo')

@section('content')


    <div class="content">
        <H1>Bem vindo</H1>    
    </div>
    <div id="search-container" class="col-md-12">
        <h1>Busque por uma casa </h1>
        <form action="">
            <input type="text" id="search" name="search" class="form-control" placeholder="Procurar..." >
        </form>
    </div>
    <div id="casas-container" class="col-md-12">
        <h2>Casas</h2>
        <p>Veja as casas disponíveis</p>
        <div id="cards-container" class="row">
            @foreach ($testes as $teste )
                <div class="card col-md-3">
                    <img src="" alt="{{$teste->property_title}}">
                    <div class="card-body">
                        <p class="card-date">29/09/2024</p>
                        <h5 class="card-title">{{$teste->property_title}}</h5>
                        
                        <a href="#" class="btn btn-primary">saber mais</a>
                    </div>
                </div>
                
            @endforeach
        </div>
    </div>


    