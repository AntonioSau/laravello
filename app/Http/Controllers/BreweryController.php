<?php

namespace App\Http\Controllers;

use App\Http\Requests\BreweryRequest;
use App\Services\Brewery\BreweryService;
use Illuminate\Http\JsonResponse;

class BreweryController extends Controller
{
    private $breweryService;

    public function __construct(BreweryService $breweryService)
    {
        $this->breweryService = $breweryService;
    }

    /**
     * Mostra una lista paginata di birrerie.
     *
     * @param BreweryRequest $request
     * @return JsonResponse
     */
    public function listBreweries(BreweryRequest $request): JsonResponse
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);

        try {
            $breweries = $this->breweryService->getPaginatedBreweries($page, $perPage);
            return response()->json($breweries);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
