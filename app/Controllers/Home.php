<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\ComboModel;

class Home extends BaseController
{
    public function index()
    {
        $productoModel = new ProductoModel();
        $comboModel = new ComboModel();

        // Obtener productos activos agrupados por tipo
        $comidas = $productoModel->getByTipo('comida');
        $bebidas = $productoModel->getByTipo('bebida');
        $viandas = $productoModel->getByTipo('vianda');
        $combos = $comboModel->getAllActivos();

        $data = [
            'title' => 'Menú principal | Mi Restaurante',
            'comidas' => $comidas,
            'bebidas' => $bebidas,
            'viandas' => $viandas,
            'combos' => $combos
        ];

        // Componer las vistas
        return view('header', $data)
            . view('navbar')
            . view('catalogo/productos')
            . view('footer');
    }
}
