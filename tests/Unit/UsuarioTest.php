<?php

namespace Tests\Unit;

use App\Models\Usuario;
use PHPUnit\Framework\TestCase;

class UsuarioTest extends TestCase
{
    public function test_authentication_uses_clave_as_password(): void
    {
        $usuario = new Usuario(['clave' => 'clave-cifrada']);

        $this->assertSame('clave-cifrada', $usuario->getAuthPassword());
    }
}
