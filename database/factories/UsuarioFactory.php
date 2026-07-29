<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'usuario' => fake()->userName(),
            'correo' => fake()->unique()->safeEmail(),
            'clave' => static::$password ??= Hash::make('password'),
            'id_rol' => 6,
        ];
    }
}
