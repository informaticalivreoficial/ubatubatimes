<?php

namespace Tests\Feature\Auth;

use App\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function test_pagina_de_login_e_exibida(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSeeLivewire(Login::class);
    }

    public function test_validacao_exige_email_e_senha(): void
    {
        Livewire::test(Login::class)
            ->set('email', '')
            ->set('password', '')
            ->call('login')
            ->assertHasErrors([
                'email' => 'required',
                'password' => 'required',
            ])
            ->assertDispatched('toast');
    }

    public function test_validacao_exige_email_valido_e_senha_minima(): void
    {
        Livewire::test(Login::class)
            ->set('email', 'email-invalido')
            ->set('password', '123')
            ->call('login')
            ->assertHasErrors([
                'email' => 'email',
                'password' => 'min',
            ])
            ->assertDispatched('toast');
    }

    public function test_credenciais_invalidas_exibem_erro(): void
    {
        Livewire::test(Login::class)
            ->set('email', 'naoexiste@example.com')
            ->set('password', 'secret123')
            ->call('login')
            ->assertHasErrors(['email'])
            ->assertDispatched('toast');

        $this->assertGuest();
    }

    public function test_usuario_inativo_nao_autentica(): void
    {
        $user = User::factory()->create([
            'password' => 'secret123',
            'status' => 0,
        ]);

        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'secret123')
            ->call('login')
            ->assertDispatched('toast');

        $this->assertGuest();
    }

    public function test_usuario_ativo_autentica_e_redireciona(): void
    {
        $user = User::factory()->create([
            'name' => 'Renato Silva',
            'password' => 'secret123',
            'status' => 1,
        ]);

        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'secret123')
            ->call('login')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin'));

        $this->assertAuthenticatedAs($user);
        $this->assertEquals(
            'Bem-vindo de volta, Renato!',
            session('toast.message')
        );
        $this->assertEquals('success', session('toast.type'));
    }

    public function test_bloqueia_apos_muitas_tentativas(): void
    {
        $email = 'throttle@example.com';
        $key = Str::transliterate(strtolower($email) . '|' . '127.0.0.1');

        RateLimiter::clear($key);

        for ($i = 0; $i < 10; $i++) {
            RateLimiter::hit($key);
        }

        Livewire::test(Login::class)
            ->set('email', $email)
            ->set('password', 'secret123')
            ->call('login')
            ->assertDispatched('toast');

        $this->assertGuest();

        RateLimiter::clear($key);
    }
}
