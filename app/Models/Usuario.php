<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'usuarios';

    // Clave primaria
    protected $primaryKey = 'id';

    // Desactivar timestamps (created_at, updated_at) - Alineado a tu migración original
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

    /**
     * 🛡️ CONTROL DE COMPATIBILIDAD DE SESIONES:
     * Al no usar la columna tradicional remember_token en la migración,
     * estos métodos vacíos evitan que Laravel truene al intentar leer/escribir el token de sesión.
     */
    public function getRememberToken() { return null; }
    public function setRememberToken($value) {}
    public function getRememberTokenName() { return ''; }

    public function rolNombre()
    {
        switch ($this->id_rol) {
            case 1: return 'Administrador';
            case 2: return 'Supervisor';
            case 3: return 'Vendedor';
            case 4: return 'Almacén';
            case 5: return 'Contador';
            case 6: return 'Cliente';
            case 7: return 'Soporte técnico';
            case 8: return 'Compras';
            case 9: return 'Recursos Humanos';
            case 10: return 'Invitado';
            case 11: return 'Abogado';
            default: return 'Usuario';
        }
    }

    public function permisos()
    {
        $permisos = [
            1 => ['ACCESO_TOTAL', 'CONFIGURACION', 'GESTION_USUARIOS'], // Administrador
            2 => ['VER_OPERACIONES', 'VER_REPORTES', 'CONFIGURACION_LIMITADA'], // Supervisor
            3 => ['REALIZAR_VENTAS', 'GESTION_CLIENTES'], // Vendedor
            4 => ['GESTION_INVENTARIO', 'MOVIMIENTOS_PRODUCTOS'], // Almacén
            5 => ['VER_REPORTES_FINANCIEROS', 'VER_REPORTES_CONTABLES'], // Contador
            6 => ['VER_HISTORIAL_PEDIDOS', 'REALIZAR_PEDIDOS'], // Cliente
            7 => ['ATENDER_INCIDENCIAS', 'MANTENIMIENTO'], // Soporte técnico
            8 => ['GESTION_ORDENES', 'GESTION_PROVEEDORES'], // Compras
            9 => ['ADMINISTRAR_PERSONAL', 'GESTION_ROLES'], // Recursos Humanos
            10 => ['VER_DEMO'], // Invitado
            11 => ['ASESORIA_LEGAL'], // Abogado
        ];

        return $permisos[$this->id_rol] ?? [];
    }

    public function tienePermiso($permiso)
    {
        return in_array($permiso, $this->permisos());
    }

    /* --- 📊 RELACIONES --- */

    public function cliente()
    {
        return $this->hasOne(\App\Models\Cliente::class, 'id_usuario');
    }

    /**
     * Relación con los movimientos de Stock (Kardex)
     * Un usuario puede registrar muchos movimientos en el almacén.
     */
    public function movimientosStock()
    {
        return $this->hasMany(\App\Models\Stock::class, 'usuario_id');
    }
}
