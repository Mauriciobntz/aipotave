<?php

namespace App\Controllers;

class LegalController extends BaseController
{
    public function terminos()
    {
        $data = [
            'title' => 'Términos de Uso | ' . get_nombre_restaurante(),
            'page_title' => 'Términos de Uso',
            'breadcrumb' => [
                ['url' => base_url('/'), 'text' => 'Inicio'],
                ['url' => '#', 'text' => 'Términos de Uso']
            ]
        ];

        return view('header', $data)
            . view('navbar')
            . view('legal/terminos')
            . view('footer');
    }

    public function privacidad()
    {
        $data = [
            'title' => 'Política de Privacidad | ' . get_nombre_restaurante(),
            'page_title' => 'Política de Privacidad',
            'breadcrumb' => [
                ['url' => base_url('/'), 'text' => 'Inicio'],
                ['url' => '#', 'text' => 'Política de Privacidad']
            ]
        ];

        return view('header', $data)
            . view('navbar')
            . view('legal/privacidad')
            . view('footer');
    }
}
