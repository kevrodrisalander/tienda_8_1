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

    /**
     * @dataProvider protectedRoutes
     */
    public function test_administration_routes_require_authentication(string $route): void
    {
        $this->get($route)->assertRedirect('/login');
    }

    public static function protectedRoutes(): array
    {
        return [
            'administration' => ['/administracion'],
            'stock' => ['/stock'],
            'inventory' => ['/inventario'],
            'shipments' => ['/envios'],
            'suppliers' => ['/provedores'],
            'users' => ['/usuarios'],
            'customers' => ['/clientes'],
            'reports' => ['/reportes/reportes'],
        ];
    }
}
