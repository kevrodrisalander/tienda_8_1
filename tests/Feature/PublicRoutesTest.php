<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    public function test_root_redirects_to_home(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/home');
    }

    public function test_login_page_is_available(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
    }
}
