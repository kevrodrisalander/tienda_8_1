<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CategoriaCard extends Component
{
    public $imagen;
    public $titulo;
    public $descripcion;
    public $url;

    public function __construct($imagen, $titulo, $descripcion, $url)
    {
        $this->imagen = $imagen;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->url = $url;
    }

    public function render()
    {
        return view('components.categoria-card');
    }
}
