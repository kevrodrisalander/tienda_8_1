<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Modelo para la tabla de marcas
class Marca extends Model
{
    use HasFactory;

    protected $table = 'marcas'; // tu tabla de marcas
    protected $fillable = ['nombre']; // ajusta según tus columnas
}
