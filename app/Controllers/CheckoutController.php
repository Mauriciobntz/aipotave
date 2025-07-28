<?php
namespace App\Controllers;

use App\Models\PedidoModel;
use App\Models\DetallePedidoModel;
use App\Models\UsuarioModel;
use CodeIgniter\Controller;

helper('carrito');

/**
 * Controlador para el proceso de checkout y confirmación de pedido.
 */
class CheckoutController extends Controller
{
    /**
     * Muestra el formulario de confirmación de pedido (GET) o procesa el pedido (POST).
     */
    public function confirmar()
    {
        $carrito = carrito_obtener();
        
        if (empty($carrito)) {
            return redirect()->to(base_url('carrito/ver'))->with('error', 'El carrito está vacío.');
        }

        if ($this->request->getMethod() === 'post') {
            return $this->procesar();
        }

        // Mostrar formulario
        $data = [
            'title' => 'Confirmar Pedido',
            'carrito' => $carrito
        ];

        try {
            return view('header', $data)
                . view('navbar')
                . view('checkout/formulario', $data)
                . view('footer');
        } catch (\Exception $e) {
            return redirect()->to(base_url('carrito/ver'))->with('error', 'Error al mostrar el formulario.');
        }
    }

    /**
     * Muestra el formulario de datos de envío.
     */
    public function formulario()
    {
        $carrito = carrito_obtener();
        if (empty($carrito)) {
            return redirect()->to(base_url('carrito'))->with('error', 'El carrito está vacío');
        }

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
            'title' => 'Datos de Envío | Mi Restaurante',
            'carrito' => $carrito,
            'subtotal' => $subtotal,
            'envio' => $envio,
            'total' => $total
        ];
        
        return view('header', $data)
            . view('navbar')
            . view('checkout/formulario', $data)
            . view('footer');
    }

    /**
     * Procesa el formulario de datos de envío.
     */
    public function procesar()
    {
        $carrito = carrito_obtener();
        if (empty($carrito)) {
            return redirect()->to(base_url('carrito'))->with('error', 'El carrito está vacío');
        }

        $request = $this->request;
        
        // Validar datos del formulario
        $rules = [
            'nombre' => 'required|min_length[3]',
            'direccion' => 'required|min_length[5]',
            'celular' => 'required|min_length[6]',
            'email' => 'permit_empty|valid_email',
            'metodo_pago' => 'required|in_list[efectivo,tarjeta,transferencia]'
        ];
        
        $validation = \Config\Services::validation();
        $validation->setRules($rules);
        
        if (!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
            $errorMessage = "Por favor completa los siguientes campos:\n";
            foreach ($errors as $field => $error) {
                switch ($field) {
                    case 'nombre':
                        $errorMessage .= "- Nombre (mínimo 3 caracteres)\n";
                        break;
                    case 'direccion':
                        $errorMessage .= "- Dirección (mínimo 5 caracteres)\n";
                        break;
                    case 'celular':
                        $errorMessage .= "- Celular (mínimo 6 caracteres)\n";
                        break;
                    case 'email':
                        $errorMessage .= "- Email (opcional, formato válido)\n";
                        break;
                    case 'metodo_pago':
                        $errorMessage .= "- Método de pago\n";
                        break;
                }
            }
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }

        // Obtener coordenadas si están disponibles
        $latitud = $this->request->getPost('latitud');
        $longitud = $this->request->getPost('longitud');
        
        // Validar coordenadas si están presentes
        if ($latitud && $longitud) {
            if (!is_numeric($latitud) || !is_numeric($longitud)) {
                return redirect()->back()->withInput()->with('error', 'Coordenadas inválidas.');
            }
        }

        // Generar código de seguimiento único
        $codigoSeguimiento = strtoupper(bin2hex(random_bytes(4)));

        // Preparar datos del pedido
        $pedidoData = [
            'nombre' => $request->getPost('nombre'),
            'correo_electronico' => $request->getPost('email'),
            'celular' => $request->getPost('celular'),
            'fecha' => date('Y-m-d H:i:s'),
            'estado' => 'pendiente',
            'estado_pago' => ($request->getPost('metodo_pago') == 'efectivo') ? 'pendiente' : 'pagado',
            'total' => $this->calcularTotal($carrito),
            'metodo_pago' => $request->getPost('metodo_pago'),
            'observaciones' => $request->getPost('observaciones'),
            'direccion_entrega' => $request->getPost('direccion'),
            'entre' => $request->getPost('entre') ?: '',
            'indicacion' => $request->getPost('indicacion') ?: '',
            'codigo_seguimiento' => $codigoSeguimiento
        ];
        
        // Agregar coordenadas si están disponibles
        if ($latitud && $longitud) {
            $pedidoData['latitud'] = $latitud;
            $pedidoData['longitud'] = $longitud;
        }

        // Guardar pedido
        $pedidoModel = new PedidoModel();
        $pedidoId = $pedidoModel->insert($pedidoData);

        // Guardar detalles del pedido
        $detalleModel = new DetallePedidoModel();
        foreach ($carrito as $item) {
            $detalleModel->insert([
                'pedido_id' => $pedidoId,
                'producto_id' => $item['tipo'] === 'producto' ? $item['id'] : null,
                'combo_id' => $item['tipo'] === 'combo' ? $item['id'] : null,
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio'],
                'observaciones' => null
            ]);
        }

        // Vaciar carrito
        carrito_vaciar();

        // Redirigir a página de éxito con código de seguimiento y método de pago
        $metodo_pago = $request->getPost('metodo_pago');
        $whatsapp = '5491122334455'; // Cambia este número por el de tu empresa
        return redirect()->to(base_url('checkout/exito/' . $codigoSeguimiento . '?metodo_pago=' . $metodo_pago . '&whatsapp=' . $whatsapp));
    }

    /**
     * Muestra la página de éxito con el código de seguimiento.
     */
    public function exito($codigo)
    {
        $metodo_pago = $this->request->getGet('metodo_pago');
        $whatsapp = $this->request->getGet('whatsapp');
        $data = [
            'title' => 'Pedido realizado',
            'codigo' => $codigo,
            'metodo_pago' => $metodo_pago,
            'whatsapp' => $whatsapp
        ];
        return view('header', $data)
            . view('navbar')
            . view('checkout/exito', $data)
            . view('footer');
    }

    /**
     * Calcula el total del pedido incluyendo envío.
     * @param array $carrito
     * @return float
     */
    private function calcularTotal($carrito)
    {
        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }
        
        // Calcular envío (ejemplo: $1000 si el subtotal es menor a $5000)
        $envio = $subtotal < 5000 ? 1000 : 0;
        
        return $subtotal + $envio;
    }
} 