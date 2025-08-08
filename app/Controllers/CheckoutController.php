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
        
        // En el checkout NO se muestra el costo de envío hasta que el usuario seleccione su ubicación
        $envio = 0; // No mostrar envío hasta que se seleccione ubicación
        $total = $subtotal; // Solo subtotal inicialmente
        
        // Cargar modelo de configuración
        $configuracionModel = new \App\Models\ConfiguracionModel();
        
        $data = [
            'title' => 'Datos de Envío | Mi Restaurante',
            'carrito' => $carrito,
            'subtotal' => $subtotal,
            'envio' => $envio,
            'total' => $total,
            'configuracionModel' => $configuracionModel
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
        
        // Debug: Log del carrito
        log_message('debug', 'CheckoutController::procesar - Carrito obtenido: ' . json_encode($carrito));
        
        if (empty($carrito)) {
            log_message('error', 'CheckoutController::procesar - Carrito vacío');
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

        // Calcular totales
        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }
        
        // Calcular costo de envío usando el helper de distancia
        helper('distancia');
        $costoEnvio = calcular_costo_envio($latitud, $longitud);
        
        // Calcular total
        $total = $subtotal + $costoEnvio;

        // Preparar datos del pedido
        $pedidoData = [
            'nombre' => $request->getPost('nombre'),
            'correo_electronico' => $request->getPost('email'),
            'celular' => $request->getPost('celular'),
            'fecha' => date('Y-m-d H:i:s'),
            'estado' => 'pendiente',
            'estado_pago' => ($request->getPost('metodo_pago') == 'efectivo') ? 'pendiente' : 'pagado',
            'total' => $total,
            'costo_envio' => $costoEnvio,
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
        $pedidoModel = new \App\Models\PedidoModel();
        $pedidoId = $pedidoModel->insert($pedidoData);
        
        // Debug: Log del resultado del pedido
        log_message('debug', 'CheckoutController::procesar - Pedido insertado con ID: ' . $pedidoId);
        
        if (!$pedidoId) {
            log_message('error', 'CheckoutController::procesar - Error al insertar pedido: ' . json_encode($pedidoData));
            return redirect()->back()->withInput()->with('error', 'Error al procesar el pedido. Inténtalo de nuevo.');
        }

        // Guardar detalles del pedido
        $detalleModel = new \App\Models\DetallePedidoModel();
        
        // Debug: Log del carrito
        log_message('debug', 'CheckoutController::procesar - Carrito: ' . json_encode($carrito));
        log_message('debug', 'CheckoutController::procesar - Pedido ID: ' . $pedidoId);
        
        // Convertir carrito de objeto asociativo a array si es necesario
        $carritoArray = is_array($carrito) && !empty($carrito) && !is_numeric(key($carrito)) ? array_values($carrito) : $carrito;
        log_message('debug', 'CheckoutController::procesar - Carrito convertido: ' . json_encode($carritoArray));
        
        foreach ($carritoArray as $item) {
            $detalleData = [
                'pedido_id' => $pedidoId,
                'producto_id' => $item['tipo'] === 'producto' ? $item['id'] : null,
                'combo_id' => $item['tipo'] === 'combo' ? $item['id'] : null,
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio'],
                'observaciones' => null
            ];
            
            // Debug: Log de cada detalle
            log_message('debug', 'CheckoutController::procesar - Insertando detalle: ' . json_encode($detalleData));
            
            $result = $detalleModel->insert($detalleData);
            
            // Debug: Log del resultado
            log_message('debug', 'CheckoutController::procesar - Resultado insert detalle: ' . var_export($result, true));
            
            if (!$result) {
                log_message('error', 'CheckoutController::procesar - Error al insertar detalle: ' . json_encode($detalleData));
                // Continuar con el siguiente item en lugar de fallar todo el pedido
            }
        }

        // Vaciar carrito
        carrito_vaciar();

        // Redirigir a página de éxito con código de seguimiento y método de pago
        $metodo_pago = $request->getPost('metodo_pago');
        $whatsapp = '543794942627'; // Cambia este número por el de tu empresa
        return redirect()->to(base_url('checkout/exito/' . $codigoSeguimiento . '?metodo_pago=' . $metodo_pago . '&whatsapp=' . $whatsapp));
    }

    /**
     * Muestra la página de éxito con el código de seguimiento.
     */
    public function exito($codigo)
    {
        $metodo_pago = $this->request->getGet('metodo_pago');
        $whatsapp = $this->request->getGet('whatsapp');
        $pedidoModel = new \App\Models\PedidoModel();
        $detalleModel = new \App\Models\DetallePedidoModel();
        $pedido = $pedidoModel->getByCodigoSeguimiento($codigo);
        $detalles = [];
        if ($pedido && isset($pedido['id'])) {
            $detalles = $detalleModel->getDetallesConInfo($pedido['id']);
        }
        $data = [
            'title' => 'Pedido realizado',
            'codigo' => $codigo,
            'metodo_pago' => $metodo_pago,
            'whatsapp' => $whatsapp,
            'pedido' => $pedido,
            'detalles' => $detalles
        ];
        return view('header', $data)
            . view('navbar')
            . view('checkout/exito', $data)
            . view('footer');
    }

    /**
     * Calcula el total del pedido incluyendo envío.
     * @param array $carrito
     * @param float|null $latitud
     * @param float|null $longitud
     * @return float
     */
    private function calcularTotal($carrito, $latitud = null, $longitud = null)
    {
        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }
        
        // Calcular costo de envío usando el helper de distancia
        helper('distancia');
        $costoEnvio = calcular_costo_envio($latitud, $longitud);
        
        return $subtotal + $costoEnvio;
    }
} 