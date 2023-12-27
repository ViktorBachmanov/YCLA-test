<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     *  @test
     */
    public function it_registers_user(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Иван',
            'patronymic' => 'Иванович',
            'family' => 'Иванов',
            'phone' => '+79161234567',
            'email' => 'ivan@mail.ru',
            'password' => 'knjs123*5sda',
            'password_confirmation' => 'knjs123*5sda',
        ]);

        $response->dumpHeaders();

        $response->dump();

        $response->assertStatus(201);
    }
}
