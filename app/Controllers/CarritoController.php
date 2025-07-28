<?php
namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\ComboModel;
use CodeIgniter\Controller;

helper('carrito');

/**
 * Controlador para el carrito de compras.
 */
class CarritoController extends Controller
{
    /**
     * Muestra el contenido del carrito.
     */
    public function verCarrito()
    {
        $carrito = carrito_obtener();
        
        // Calcular totales
        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }
        
        // Calcular envío (ejemplo: $1000 si el subtotal es menor a $5000)
        $envio = $subtotal < 5000 ? 1000 : 0;
        
        // Calcular total
        $total = $subtotal + $envio;
        
        $data = [
            'title' => 'Mi Carrito | Mi Restaurante',
            'carrito' => $carrito,
            'subtotal' => $subtotal,
            'envio' => $envio,
            'total' => $total
        ];
        return view('header', $data)
            . view('navbar')
            . view('carrito/ver')
            . view('footer');
    }

    /**
     * Agrega un producto o combo al carrito.
     * Espera POST con id, tipo ('producto' o 'combo'), cantidad.
     */
    public function agregarProducto()
    {
        $tipo = $this->request->getPost('tipo');
        $id = (int)$this->request->getPost('id');
        $cantidad = (int)$this->request->getPost('cantidad');
        if ($cantidad < 1) $cantidad = 1;

        if ($tipo === 'producto') {
            $model = new ProductoModel();
            $item = $model->getById($id);
        } elseif ($tipo === 'combo') {
            $model = new ComboModel();
            $item = $model->getById($id);
        } else {
            return redirect()->back()->with('error', 'Tipo inválido');
        }

        if (!$item) {
            return redirect()->back()->with('error', 'No encontrado');
        }

        $carritoItem = [
            'id' => $item['id'],
            'tipo' => $tipo,
            'nombre' => $item['nombre'],
            'precio' => $item['precio'],
            'cantidad' => $cantidad,
            'imagen' => $item['imagen'] ?? null
        ];
        carrito_agregar($carritoItem);
        return redirect()->to('/carrito')->with('success', 'Agregado al carrito');
    }

    /**
     * Actualiza la cantidad de un ítem en el carrito.
     * Espera POST con tipo, id, cantidad.
     */
    public function actualizarCantidad()
    {
        $tipo = $this->request->getPost('tipo');
        $id = (int)$this->request->getPost('id');
        $cantidad = (int)$this->request->getPost('cantidad');
        carrito_actualizar_cantidad($tipo, $id, $cantidad);
        return redirect()->to('/carrito');
    }

    /**
     * Elimina un ítem del carrito.
     * Espera GET o POST con tipo, id.
     */
    public function eliminarItem($tipo, $id)
    {
        carrito_eliminar($tipo, $id);
        return redirect()->to('/carrito');
    }

    /**
     * Vacía el carrito completamente.
     */
    public function vaciarCarrito()
    {
        carrito_vaciar();
        return redirect()->to('/carrito');
    }

    /**
     * Inicia el proceso de compra (checkout).
     */
    public function comprar()
    {
        $carrito = carrito_obtener();
        if (empty($carrito)) {
            return redirect()->to('/carrito')->with('error', 'El carrito está vacío');
        }
        
        // Redirigir al formulario de checkout
        return redirect()->to('/checkout/formulario');
    }
} 