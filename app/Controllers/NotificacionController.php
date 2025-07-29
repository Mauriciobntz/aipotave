<?php
namespace App\Controllers;

use App\Models\NotificacionModel;
use App\Models\PedidoModel;
use CodeIgniter\Controller;

class NotificacionController extends Controller
{
    protected $notificacionModel;
    protected $pedidoModel;

    public function __construct()
    {
        $this->notificacionModel = new NotificacionModel();
        $this->pedidoModel = new PedidoModel();
    }

    /**
     * Envía una notificación cuando cambia el estado de un pedido
     */
    public function enviarNotificacionEstado($pedido_id, $nuevo_estado)
    {
        $pedido = $this->pedidoModel->getById($pedido_id);
        
        if (!$pedido) {
            return false;
        }

        $mensajes = [
            'confirmado' => 'Su pedido #' . $pedido['codigo_seguimiento'] . ' ha sido confirmado y está en preparación',
            'en_preparacion' => 'Su pedido #' . $pedido['codigo_seguimiento'] . ' está siendo preparado',
            'en_camino' => 'Su pedido #' . $pedido['codigo_seguimiento'] . ' está en camino hacia su dirección',
            'entregado' => 'Su pedido #' . $pedido['codigo_seguimiento'] . ' ha sido entregado. ¡Gracias por su compra!',
            'cancelado' => 'Su pedido #' . $pedido['codigo_seguimiento'] . ' ha sido cancelado'
        ];

        $mensaje = $mensajes[$nuevo_estado] ?? 'El estado de su pedido #' . $pedido['codigo_seguimiento'] . ' ha cambiado a: ' . $nuevo_estado;

        // Enviar notificación por WhatsApp (simulado)
        $this->notificacionModel->registrarNotificacion($pedido_id, 'whatsapp', $mensaje);

        // Enviar notificación por email (simulado)
        $this->notificacionModel->registrarNotificacion($pedido_id, 'email', $mensaje);

        return true;
    }

    /**
     * Envía una notificación al repartidor cuando se le asigna un pedido
     */
    public function enviarNotificacionRepartidor($repartidor_id, $pedido_id)
    {
        $pedido = $this->pedidoModel->getById($pedido_id);
        
        if (!$pedido) {
            return false;
        }

        $mensaje = "Nuevo pedido asignado: #{$pedido['codigo_seguimiento']} - {$pedido['direccion_entrega']}";

        // Registrar la notificación para el repartidor
        $this->notificacionModel->registrarNotificacion($pedido_id, 'repartidor', $mensaje, $repartidor_id);

        return true;
    }

    /**
     * Lista las notificaciones (solo para administradores)
     */
    public function listar()
    {
        $filtro_tipo = $this->request->getGet('tipo');
        $filtro_estado = $this->request->getGet('estado');

        if ($filtro_tipo) {
            $notificaciones = $this->notificacionModel->getByTipo($filtro_tipo);
        } elseif ($filtro_estado) {
            $notificaciones = $this->notificacionModel->getByEstado($filtro_estado);
        } else {
            $notificaciones = $this->notificacionModel->findAll();
        }

        $data = [
            'notificaciones' => $notificaciones,
            'filtro_tipo' => $filtro_tipo,
            'filtro_estado' => $filtro_estado
        ];

        return view('admin/notificaciones/listar', $data);
    }

    /**
     * Muestra el detalle de una notificación
     */
    public function detalle($id)
    {
        $notificacion = $this->notificacionModel->find($id);
        
        if (!$notificacion) {
            return redirect()->to(base_url('admin/notificaciones'))->with('error', 'Notificación no encontrada');
        }

        $pedido = $this->pedidoModel->getById($notificacion['pedido_id']);
        
        $data = [
            'notificacion' => $notificacion,
            'pedido' => $pedido
        ];

        return view('admin/notificaciones/detalle', $data);
    }

    /**
     * Actualiza el estado de una notificación
     */
    public function actualizarEstado($id)
    {
        $estado = $this->request->getPost('estado');
        
        if (!in_array($estado, ['pendiente', 'enviado', 'fallido'])) {
            return redirect()->back()->with('error', 'Estado no válido');
        }

        if ($this->notificacionModel->actualizarEstado($id, $estado)) {
            return redirect()->back()->with('success', 'Estado actualizado correctamente');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el estado');
        }
    }

    /**
     * Reenvía una notificación fallida
     */
    public function reenviar($id)
    {
        $notificacion = $this->notificacionModel->find($id);
        
        if (!$notificacion) {
            return redirect()->back()->with('error', 'Notificación no encontrada');
        }

        if ($notificacion['estado'] !== 'fallido') {
            return redirect()->back()->with('error', 'Solo se pueden reenviar notificaciones fallidas');
        }

        // Aquí iría la lógica real de envío
        // Por ahora solo actualizamos el estado
        if ($this->notificacionModel->actualizarEstado($id, 'enviado')) {
            return redirect()->back()->with('success', 'Notificación reenviada correctamente');
        } else {
            return redirect()->back()->with('error', 'Error al reenviar la notificación');
        }
    }

    /**
     * Muestra estadísticas de notificaciones
     */
    public function estadisticas()
    {
        $fecha_inicio = $this->request->getGet('fecha_inicio') ?? date('Y-m-d', strtotime('-30 days'));
        $fecha_fin = $this->request->getGet('fecha_fin') ?? date('Y-m-d');

        $estadisticas = $this->notificacionModel->getEstadisticasNotificaciones($fecha_inicio, $fecha_fin);

        $data = [
            'estadisticas' => $estadisticas,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin
        ];

        return view('admin/notificaciones/estadisticas', $data);
    }
} 