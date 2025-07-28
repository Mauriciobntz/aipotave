<?php
namespace App\Controllers;

use App\Models\PedidoModel;
use App\Models\DetallePedidoModel;
use App\Models\HistorialEstadosModel;
use App\Models\CalificacionModel;
use CodeIgniter\Controller;

/**
 * Controlador para el seguimiento de pedidos por código de seguimiento.
 */
class PedidoController extends Controller
{
    protected $pedidoModel;
    protected $detalleModel;
    protected $historialModel;
    protected $calificacionModel;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->detalleModel = new DetallePedidoModel();
        $this->historialModel = new HistorialEstadosModel();
        $this->calificacionModel = new CalificacionModel();
    }

    /**
     * Muestra el estado y detalles de un pedido por código de seguimiento.
     */
    public function seguimiento($codigo)
    {
        $pedido = $this->pedidoModel->getByCodigoSeguimiento($codigo);
        if (!$pedido) {
            return redirect()->to(base_url('/'))->with('error', 'Código de seguimiento no encontrado.');
        }

        $detalles = $this->detalleModel->getDetallesConInfo($pedido['id']);
        $historial = $this->historialModel->getByPedidoId($pedido['id']);
        $calificacion = $this->calificacionModel->getByPedidoId($pedido['id']);

        $data = [
            'title' => 'Seguimiento de Pedido',
            'pedido' => $pedido,
            'detalles' => $detalles,
            'historial' => $historial,
            'calificacion' => $calificacion,
            'codigo_seguimiento' => $codigo
        ];
        return view('header', $data)
            . view('navbar')
            . view('pedido/seguimiento')
            . view('footer');
    }

    /**
     * Redirige el formulario GET de la navbar al seguimiento correcto.
     */
    public function index()
    {
        $codigo = $this->request->getGet('codigo');
        if ($codigo) {
            return redirect()->to(base_url('pedido/seguimiento/' . urlencode($codigo)));
        }
        return redirect()->to(base_url('/'));
    }

    /**
     * Muestra el historial completo de un pedido
     */
    public function historial($codigo)
    {
        $pedido = $this->pedidoModel->getByCodigoSeguimiento($codigo);
        if (!$pedido) {
            return redirect()->to(base_url('/'))->with('error', 'Código de seguimiento no encontrado.');
        }

        $historial = $this->historialModel->getByPedidoId($pedido['id']);
        
        $data = [
            'title' => 'Historial del Pedido',
            'pedido' => $pedido,
            'historial' => $historial
        ];
        return view('header', $data)
            . view('navbar')
            . view('pedido/historial')
            . view('footer');
    }

    /**
     * Muestra los detalles completos de un pedido
     */
    public function detalles($codigo)
    {
        $pedido = $this->pedidoModel->getByCodigoSeguimiento($codigo);
        if (!$pedido) {
            return redirect()->to(base_url('/'))->with('error', 'Código de seguimiento no encontrado.');
        }

        $detalles = $this->detalleModel->getDetallesCompletos($pedido['id']);
        
        $data = [
            'title' => 'Detalles del Pedido',
            'pedido' => $pedido,
            'detalles' => $detalles
        ];
        return view('header', $data)
            . view('navbar')
            . view('pedido/detalles')
            . view('footer');
    }
} 