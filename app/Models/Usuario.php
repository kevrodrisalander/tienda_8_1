<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    // Nombre de la tabla
    protected $table = 'usuarios';

    // Clave primaria
    protected $primaryKey = 'id';

    // Desactivar timestamps (created_at, updated_at)
    public $timestamps = false;

    // Campos asignables masivamente
    protected $fillable = [
        'usuario',
        'correo',
        'clave',
        'id_rol',
    ];

    // Campos ocultos (no se muestran al serializar)
    protected $hidden = [
        'clave',
    ];

    /**
     * Laravel por defecto usa "password" para autenticar.
     * Aquí le decimos que use tu campo "clave".
     */
    public function getAuthPassword()
    {
        return $this->clave;
    }

    /**
     * Campo de login (username) para Auth.
     * Laravel lo usará en Auth::attempt()
     */
    public function username()
    {
        return 'correo';
    }

    public function rolNombre()
{
    switch ($this->id_rol) {
        case 1: return 'Administrador';
        case 6: return 'Cliente';
        default: return 'Usuario';
    }
}
}
