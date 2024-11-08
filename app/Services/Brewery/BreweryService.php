<?php

namespace App\Services\Brewery;

use App\Traits\ConsumesExternalService;

class BreweryService
{
    use ConsumesExternalService;

    private const API_BASE_URL = 'https://api.openbrewerydb.org/v1/breweries';

    /**
     * Restituisce una lista paginata di birrerie.
     *
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function getPaginatedBreweries(int $page = 1, int $perPage = 10): array
    {
        $queryParams = [
            'page' => $page,
            'per_page' => $perPage,
        ];

        return $this->performGetRequest(self::API_BASE_URL, $queryParams);
    }
}
