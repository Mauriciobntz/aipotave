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
        
        // En el carrito NO se muestra el costo de envío hasta que el usuario vaya al checkout
        $envio = 0; // No mostrar envío en el carrito
        $total = $subtotal; // Solo subtotal en el carrito
        
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
        // Verificar que sea una petición POST
        if (!$this->request->is('post')) {
            return redirect()->back()->with('error', 'Método no permitido');
        }

        // Obtener y validar datos
        $tipo = $this->request->getPost('tipo');
        $id = (int)$this->request->getPost('id');
        $cantidad = (int)$this->request->getPost('cantidad');
        
        // Validaciones básicas
        if (empty($tipo) || empty($id) || $cantidad < 1) {
            return redirect()->back()->with('error', 'Datos inválidos: tipo, id y cantidad son requeridos');
        }

        if ($cantidad < 1) $cantidad = 1;

        try {
            if ($tipo === 'producto') {
                $model = new ProductoModel();
                $item = $model->getById($id);
            } elseif ($tipo === 'combo') {
                $model = new ComboModel();
                $item = $model->getById($id);
            } else {
                return redirect()->back()->with('error', 'Tipo inválido: debe ser "producto" o "combo"');
            }

            if (!$item) {
                return redirect()->back()->with('error', 'Producto no encontrado');
            }

            // Verificar que el producto esté activo
            if (isset($item['activo']) && !$item['activo']) {
                return redirect()->back()->with('error', 'Este producto no está disponible');
            }

            $carritoItem = [
                'id' => $item['id'],
                'tipo' => $tipo,
                'nombre' => $item['nombre'],
                'precio' => $item['precio'],
                'cantidad' => $cantidad,
                'imagen' => $item['imagen'] ?? null
            ];

            // Agregar al carrito
            carrito_agregar($carritoItem);

            // Verificar que se agregó correctamente
            $carrito_actual = carrito_obtener();
            $key = $tipo . '_' . $id;
            
            if (!isset($carrito_actual[$key])) {
                return redirect()->back()->with('error', 'Error al agregar al carrito');
            }

            // Si es una petición AJAX, devolver JSON
            if ($this->request->getHeader('X-Requested-With') || 
                $this->request->getHeader('Accept') === 'application/json') {
                
                // Contar items en el carrito
                $total_items = 0;
                foreach ($carrito_actual as $item) {
                    $total_items += $item['cantidad'];
                }
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Producto agregado al carrito',
                    'cartCount' => $total_items
                ]);
            }

            return redirect()->to(base_url('carrito'))->with('success', 'Producto agregado al carrito correctamente');

        } catch (\Exception $e) {
            // Log del error para debugging
            log_message('error', 'Error al agregar producto al carrito: ' . $e->getMessage());
            
            // Si es AJAX, devolver JSON
            if ($this->request->getHeader('X-Requested-With') || 
                $this->request->getHeader('Accept') === 'application/json') {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error interno al agregar al carrito'
                ]);
            }
            
            return redirect()->back()->with('error', 'Error interno al agregar al carrito');
        }
    }

    /**
     * Actualiza la cantidad de un ítem en el carrito.
     * Espera POST con tipo, id, cantidad.
     */
    public function actualizarCantidad()
    {
        if (!$this->request->is('post')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Método no permitido']);
        }

        $tipo = $this->request->getPost('tipo');
        $id = (int)$this->request->getPost('id');
        $cantidad = (int)$this->request->getPost('cantidad');
        
        if (empty($tipo) || empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Datos inválidos']);
        }

        try {
            carrito_actualizar_cantidad($tipo, $id, $cantidad);
            
            // Obtener el carrito actualizado
            $carrito = carrito_obtener();
            
            // Calcular totales
            $subtotal = 0;
            foreach ($carrito as $item) {
                $subtotal += $item['precio'] * $item['cantidad'];
            }
            
            // En el carrito NO se muestra el costo de envío hasta que el usuario vaya al checkout
            $envio = 0; // No mostrar envío en el carrito
            $total = $subtotal; // Solo subtotal en el carrito
            
            // Obtener el precio del producto actualizado
            $key = $tipo . '_' . $id;
            $precio = isset($carrito[$key]) ? $carrito[$key]['precio'] : 0;
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Cantidad actualizada',
                'precio' => $precio,
                'subtotal' => $subtotal,
                'envio' => $envio,
                'total' => $total
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Error al actualizar cantidad: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Error interno']);
        }
    }

    /**
     * Elimina un ítem del carrito.
     * Espera GET o POST con tipo, id.
     */
    public function eliminarItem($tipo, $id)
    {
        if (empty($tipo) || empty($id)) {
            return redirect()->back()->with('error', 'Datos inválidos');
        }

        carrito_eliminar($tipo, $id);
        return redirect()->to(base_url('carrito'))->with('success', 'Producto eliminado del carrito');
    }

    /**
     * Vacía el carrito completamente.
     */
    public function vaciarCarrito()
    {
        carrito_vaciar();
        return redirect()->to(base_url('carrito'))->with('success', 'Carrito vaciado');
    }

    /**
     * Inicia el proceso de compra (checkout).
     */
    public function comprar()
    {
        $carrito = carrito_obtener();
        if (empty($carrito)) {
            return redirect()->to(base_url('carrito'))->with('error', 'El carrito está vacío');
        }
        
        // Redirigir al formulario de checkout
        return redirect()->to(base_url('checkout/formulario'));
    }

    /**
     * API para agregar producto al carrito (AJAX)
     */
    public function agregarAjax()
    {
        if (!$this->request->is('post')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Método no permitido']);
        }

        $tipo = $this->request->getPost('tipo');
        $id = (int)$this->request->getPost('id');
        $cantidad = (int)$this->request->getPost('cantidad');
        
        if (empty($tipo) || empty($id) || $cantidad < 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Datos inválidos']);
        }

        try {
            if ($tipo === 'producto') {
                $model = new ProductoModel();
                $item = $model->getById($id);
            } elseif ($tipo === 'combo') {
                $model = new ComboModel();
                $item = $model->getById($id);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Tipo inválido']);
            }

            if (!$item) {
                return $this->response->setJSON(['success' => false, 'message' => 'Producto no encontrado']);
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

            // Contar items en el carrito
            $carrito = carrito_obtener();
            $total_items = 0;
            foreach ($carrito as $item) {
                $total_items += $item['cantidad'];
            }

            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Producto agregado al carrito',
                'cartCount' => $total_items
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error en agregarAjax: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Error interno']);
        }
    }
} 