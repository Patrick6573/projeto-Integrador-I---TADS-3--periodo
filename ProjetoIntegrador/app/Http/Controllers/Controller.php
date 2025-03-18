<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

abstract class Controller
{
    
    public function getCoordinates($address)
{
    $apiKey = env('GOOGLE_MAPS_API_KEY'); // Pegue a chave do .env
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . $apiKey;

    $response = Http::get($url);
    $data = $response->json();

    if ($data['status'] === 'OK') {
        $location = $data['results'][0]['geometry']['location'];
        return [
            'latitude' => $location['lat'],
            'longitude' => $location['lng']
        ];
    }

    return null; // Retorna null se não encontrar
}


}
