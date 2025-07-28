<?php
namespace App\Controllers;

use App\Models\CalificacionModel;
use App\Models\PedidoModel;
use CodeIgniter\Controller;

class CalificacionController extends Controller
{
    protected $calificacionModel;
    protected $pedidoModel;

    public function __construct()
    {
        $this->calificacionModel = new CalificacionModel();
        $this->pedidoModel = new PedidoModel();
    }

    /**
     * Muestra el formulario para calificar un pedido
     */
    public function calificar($codigo_seguimiento)
    {
        $pedido = $this->pedidoModel->getByCodigoSeguimiento($codigo_seguimiento);
        
        if (!$pedido) {
            return redirect()->to(base_url('pedido/seguimiento'))->with('error', 'Pedido no encontrado');
        }

        // Verificar si ya existe una calificación
        $calificacion = $this->calificacionModel->getByPedidoId($pedido['id']);
        if ($calificacion) {
            return redirect()->to(base_url('pedido/seguimiento/' . $codigo_seguimiento))->with('error', 'Este pedido ya fue calificado');
        }

        $data = [
            'pedido' => $pedido,
            'codigo_seguimiento' => $codigo_seguimiento
        ];

        return view('calificacion/formulario', $data);
    }

    /**
     * Procesa la calificación del pedido
     */
    public function procesarCalificacion()
    {
        $request = $this->request->getPost();
        
        $rules = [
            'pedido_id' => 'required|integer',
            'puntuacion' => 'required|integer|greater_than[0]|less_than_equal_to[5]',
            'comentario' => 'permit_empty|max_length[500]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $pedido_id = $request['pedido_id'];
        $puntuacion = $request['puntuacion'];
        $comentario = $request['comentario'] ?? '';

        // Verificar que el pedido existe y está entregado
        $pedido = $this->pedidoModel->find($pedido_id);
        if (!$pedido || $pedido['estado'] !== 'entregado') {
            return redirect()->back()->with('error', 'El pedido no puede ser calificado');
        }

        // Verificar que no existe una calificación previa
        $calificacionExistente = $this->calificacionModel->getByPedidoId($pedido_id);
        if ($calificacionExistente) {
            return redirect()->back()->with('error', 'Este pedido ya fue calificado');
        }

        // Crear la calificación
        $data = [
            'pedido_id' => $pedido_id,
            'puntuacion' => $puntuacion,
            'comentario' => $comentario,
            'fecha' => date('Y-m-d H:i:s')
        ];

        if ($this->calificacionModel->insert($data)) {
            return redirect()->to(base_url('pedido/seguimiento/' . $pedido['codigo_seguimiento']))->with('success', '¡Gracias por tu calificación!');
        } else {
            return redirect()->back()->with('error', 'Error al procesar la calificación');
        }
    }

    /**
     * Muestra las calificaciones (solo para administradores)
     */
    public function listar()
    {
        $calificaciones = $this->calificacionModel->getCalificacionesConPedido();
        
        $data = [
            'calificaciones' => $calificaciones,
            'promedio' => $this->calificacionModel->getPromedioCalificaciones(),
            'estadisticas' => $this->calificacionModel->getEstadisticasCalificaciones()
        ];

        return view('admin/calificaciones/listar', $data);
    }

    /**
     * Muestra el detalle de una calificación
     */
    public function detalle($id)
    {
        $calificacion = $this->calificacionModel->find($id);
        
        if (!$calificacion) {
            return redirect()->to(base_url('admin/calificaciones'))->with('error', 'Calificación no encontrada');
        }

        $pedido = $this->pedidoModel->getById($calificacion['pedido_id']);
        
        $data = [
            'calificacion' => $calificacion,
            'pedido' => $pedido
        ];

        return view('admin/calificaciones/detalle', $data);
    }
} 