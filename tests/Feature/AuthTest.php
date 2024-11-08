<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_and_receive_token()
    {
        // Crea un utente di test
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Esegui la richiesta di login
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Controlla che la risposta sia corretta
        $response->assertStatus(200)
                 ->assertJsonStructure(['token']);
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        // Prova a fare il login con credenziali sbagliate
        $response = $this->postJson('/api/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        // Verifica che la risposta sia un errore 401
        $response->assertStatus(401)
                 ->assertJson(['error' => 'Unauthorized']);
    }
}
