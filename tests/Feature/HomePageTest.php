<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_homepage_uses_fancy_decorators_content(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Fancy Decorators');
        $response->assertSee('Luxury Construction');
    }
}
