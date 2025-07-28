<?php
/**
 * Helper para manejar el carrito de compras en sesión.
 * Funciones: agregar, actualizar, eliminar, vaciar y obtener el carrito.
 */

if (!function_exists('carrito_obtener')) {
    function carrito_obtener()
    {
        // Intentar usar CodeIgniter session primero
        if (function_exists('session')) {
            $session = session();
            return $session->get('carrito') ?? [];
        }
        
        // Fallback a $_SESSION
        return $_SESSION['carrito'] ?? [];
    }
}

if (!function_exists('carrito_guardar')) {
    function carrito_guardar($carrito)
    {
        // Intentar usar CodeIgniter session primero
        if (function_exists('session')) {
            $session = session();
            $session->set('carrito', $carrito);
        } else {
            // Fallback a $_SESSION
            $_SESSION['carrito'] = $carrito;
        }
    }
}

if (!function_exists('carrito_agregar')) {
    /**
     * Agrega un producto o combo al carrito.
     * $item debe ser un array con: id, tipo ('producto' o 'combo'), nombre, precio, cantidad, imagen
     */
    function carrito_agregar($item)
    {
        $carrito = carrito_obtener();
        $key = $item['tipo'] . '_' . $item['id'];
        if (isset($carrito[$key])) {
            $carrito[$key]['cantidad'] += $item['cantidad'];
        } else {
            $carrito[$key] = $item;
        }
        carrito_guardar($carrito);
    }
}

if (!function_exists('carrito_actualizar_cantidad')) {
    function carrito_actualizar_cantidad($tipo, $id, $cantidad)
    {
        $carrito = carrito_obtener();
        $key = $tipo . '_' . $id;
        if (isset($carrito[$key])) {
            $carrito[$key]['cantidad'] = $cantidad;
            if ($cantidad <= 0) {
                unset($carrito[$key]);
            }
            carrito_guardar($carrito);
        }
    }
}

if (!function_exists('carrito_eliminar')) {
    function carrito_eliminar($tipo, $id)
    {
        $carrito = carrito_obtener();
        $key = $tipo . '_' . $id;
        if (isset($carrito[$key])) {
            unset($carrito[$key]);
            carrito_guardar($carrito);
        }
    }
}

if (!function_exists('carrito_vaciar')) {
    function carrito_vaciar()
    {
        // Intentar usar CodeIgniter session primero
        if (function_exists('session')) {
            $session = session();
            $session->remove('carrito');
        } else {
            // Fallback a $_SESSION
            unset($_SESSION['carrito']);
        }
    }
} 