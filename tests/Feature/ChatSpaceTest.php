<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChatSpaceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_chat_space_page_requires_authentication()
    {
        $response = $this->get('/chat/espacio');
        
        $response->assertRedirect('/login');
    }

    /** @test */
    public function test_authenticated_user_can_view_chat_space()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/chat/espacio');
        
        $response->assertStatus(200);
        $response->assertViewIs('chat.espacio');
        $response->assertViewHas(['espacioTotal', 'espacioUsado', 'espacioDisponible', 'porcentajeUsado']);
    }

    /** @test */
    public function test_chat_space_cleanup_requires_authentication()
    {
        $response = $this->post('/chat/limpiar');
        
        $response->assertRedirect('/login');
    }

    /** @test */
    public function test_authenticated_user_can_clean_chat_space()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post('/chat/limpiar');
        
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['success', 'message', 'espacioLiberado']);
    }
}