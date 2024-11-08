<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ConsumesExternalService
{
    /**
     * Effettua una richiesta GET all'URL specificato e ritorna i dati.
     *
     * @param string $url
     * @param array $queryParams
     * @return array
     */
    public function performGetRequest(string $url, array $queryParams = []): array
    {
        $response = Http::get($url, $queryParams);

        if ($response->failed()) {
            throw new \Exception('Error retrieving data from external service.');
        }

        return $response->json();
    }
}
