@extends('layouts.main')

@section('title', 'Bem vindo')

@section('content')

    <style>
        .house-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            /* Centraliza os botões */
            margin-top: 20px;
        }

        .house-actions a,
        .house-actions button {
            flex: 1;
            min-width: 150px;
            /* Para manter um tamanho mínimo nos botões */
            text-align: center;
        }
            .secondary-photos-container {
                margin-top: 20px;
                padding: 10px;
                border-radius: 8px;
            }

            .secondary-photos {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            .secondary-photos img,
            .secondary-photos video {
                width: 160px;
                /* Tamanho aumentado */
                height: 100px;
                border-radius: 5px;
            }

        }
    </style>

    <h1 style="font-size: 36px; font-weight: bold; color: #333; margin-bottom: 20px; padding-top: 30px;; text-align:center">
        {{ $property->property_title }}
    </h1>

    <div class="house-details-container"
        style="display: flex; flex-direction: row; gap: 20px; padding: 20px; max-width: 800px; margin: 0 auto; align-items: flex-start; justify-content: center; background-color: #f8f9fa; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <!-- Imagem da Casa -->
        <div class="house-image">
            <img src="{{ asset('img/casas/' . $property->primary_photo->name_file) }}" alt="Foto da Casa"
                style="width: 400px; height: auto; border-radius: 8px;">

            @if($property->photos)
                <div class="secondary-photos-container"
                    style="margin-top: 20px; padding: 20px; background-color: #e9ecef; border-radius: 8px;">
                    <h2 style="font-size: 24px; font-weight: bold; color: #333; margin-bottom: 10px;"></h2>

                    <div class="secondary-photos" style="display: flex; flex-wrap: wrap; gap: 10px;">
                        @foreach($property->photos as $index => $file)
                            @if(in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                <img src="{{ asset('img/casas/' . $file) }}" alt="Foto"
                                    class="secondary-photo {{ $index >= 2 ? 'hidden' : '' }}"
                                    style="width: 150px; height: auto; border-radius: 5px;">
                            @elseif(in_array(pathinfo($file, PATHINFO_EXTENSION), ['mp4', 'mov', 'avi', 'webm']))
                                <video width="150" controls class="secondary-photo {{ $index >= 2 ? 'hidden' : '' }}"
                                    style="border-radius: 5px;">
                                    <source src="{{ asset('img/casas/' . $file) }}"
                                        type="video/{{ pathinfo($file, PATHINFO_EXTENSION) }}">
                                    Seu navegador não suporta vídeos.
                                </video>
                            @endif
                        @endforeach
                    </div>

                    @if(count($property->photos) > 2)
                        <button onclick="togglePhotos()" id="showMoreBtn"
                            style="margin-top: 10px; padding: 10px 15px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;">
                            Mostrar mais fotos
                        </button>
                    @endif
                </div>
            @endif

            <script>
                function togglePhotos() {
                    let hiddenPhotos = document.querySelectorAll('.secondary-photo.hidden');
                    let button = document.getElementById('showMoreBtn');

                    hiddenPhotos.forEach(photo => {
                        photo.classList.toggle('hidden');
                    });

                    button.textContent = button.textContent === 'Mostrar mais fotos' ? 'Mostrar menos' : 'Mostrar mais fotos';
                }
            </script>

            <style>
                .hidden {
                    display: none;
                }
            </style>
        </div>

        <!-- Detalhes da Casa -->
        <div class="house-info">
            <p><strong>Endereço:</strong> {{ $property->street }}, {{ $property->number }}</p>
            <p><strong>Bairro:</strong> {{ $property->neighborhood }}</p>
            <p><strong>Cidade:</strong> {{ $property->city }} - {{$property->state}}</p>
            <p><strong>Preço:</strong> R$ {{ number_format($property->rental_value, 2, ',', '.') }}</p>
            <p><strong>Descrição:</strong> {{ $property->property_description }}</p>
            <p><strong>Tipo:</strong> {{$property->property_type}}</p>
            <p><strong>Tamalho:</strong> {{$property->property_size}} </p>
            <p><strong>Ponto de Referencia:</strong> {{$property->reference_point}} </p>
            <p><strong>Complemento:</strong> {{$property->complement}} </p>

            <!-- Outros detalhes da casa -->
            <p><strong>Quartos:</strong> {{ $property->number_rooms }}</p>
            <p><strong>Banheiros:</strong> {{ $property->number_bathrooms }}</p>


            <!-- Botões de Ação -->
            <div class="house-actions" style="margin-top: 20px;">
                <a href="{{ route('exibir.form', ['id' => $property->id]) }}"" style=" padding: 10px 20px; background-color:
                    #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    Solicitar Visita
                </a>

                <a href="{{ url('/chats?target=' . $property->fk_id_user) }}"
                    style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
                    Conversar
                </a>
                <!-- Botão para abrir o modal do Google Maps -->
                <!-- Botão para abrir o modal do Google Maps -->
                <button
                    onclick="openMapModal('{{ $property->street }}', '{{ $property->number }}', '{{ $property->city }}', '{{ $property->state }}', '{{ $property->latitude }}', '{{ $property->longitude }}')"
                    style="padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
                    Ver no Maps
                </button>

            </div>
        </div>
    </div>

    <!-- Seção para fotos secundárias -->


    <!-- Modal do Google Maps -->
    <div id="mapModal" class="modal"
        style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
        <div class="modal-content"
            style="background: white; margin: 10% auto; padding: 20px; width: 80%; max-width: 600px; position: relative;">
            <span onclick="closeMapModal()"
                style="position: absolute; top: 10px; right: 15px; font-size: 20px; cursor: pointer;">&times;</span>
            <h2>Localização do Imóvel</h2>
            <div id="map" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
    <script>
        function openMapModal(street, number, city, state, lat, lng) {
            document.getElementById("mapModal").style.display = "block";

            if (lat && lng) {
                initMap(parseFloat(lat), parseFloat(lng));
            } else {
                let address = `${street}, ${number}, ${city}, ${state}`;
                let geocoder = new google.maps.Geocoder();
                geocoder.geocode({ 'address': address }, function (results, status) {
                    if (status === 'OK') {
                        initMap(results[0].geometry.location.lat(), results[0].geometry.location.lng());
                    } else {
                        alert("Não foi possível encontrar a localização.");
                    }
                });
            }
        }

        function closeMapModal() {
            document.getElementById("mapModal").style.display = "none";
        }

        function initMap(lat, lng) {
            let map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: lat, lng: lng },
                zoom: 15
            });

            new google.maps.Marker({
                position: { lat: lat, lng: lng },
                map: map
            });
        }
    </script>

    <!-- API do Google Maps (substitua SUA_API_KEY pela sua chave) -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKSFMDxS2tbKozM55sfuhZcHEcHEsiDfk"></script>




@endsection