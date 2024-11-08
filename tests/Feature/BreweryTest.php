<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class BreweryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_access_breweries()
    {
        // Crea un utente di test e ottieni il token
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = auth()->attempt(['email' => 'test@example.com', 'password' => 'password']);

        // Esegui la richiesta per ottenere le birre
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->getJson('/api/breweries');

        // Verifica che la richiesta abbia avuto successo e abbia una struttura corretta
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => ['id', 'name', 'brewery_type', 'city', 'state']
                 ]);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_breweries()
    {
        // Esegui la richiesta senza autenticazione
        $response = $this->getJson('/api/breweries');

        // Verifica che la risposta sia 401
        $response->assertStatus(401)
                ->assertJson(['message' => 'Unauthenticated.']);
    }
}
