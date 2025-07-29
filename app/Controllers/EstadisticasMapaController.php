<?php

namespace App\Controllers;

use App\Models\PedidoModel;
use CodeIgniter\Controller;

class EstadisticasMapaController extends Controller
{
    public function index()
    {
        // Obtener filtros
        $periodo = $this->request->getGet('periodo') ?? 'mes';
        $estado = $this->request->getGet('estado') ?? '';
        $fecha_desde = $this->request->getGet('fecha_desde') ?? '';
        $fecha_hasta = $this->request->getGet('fecha_hasta') ?? '';

        $pedidoModel = new PedidoModel();
        
        // Construir filtros
        $filtros = [];
        
        if ($estado) {
            $filtros['estado'] = $estado;
        }
        
        if ($fecha_desde) {
            $filtros['fecha_desde'] = $fecha_desde;
        }
        
        if ($fecha_hasta) {
            $filtros['fecha_hasta'] = $fecha_hasta;
        }
        
        // Aplicar filtro de período
        switch ($periodo) {
            case 'hoy':
                $filtros['fecha_desde'] = date('Y-m-d');
                $filtros['fecha_hasta'] = date('Y-m-d');
                break;
            case 'semana':
                $filtros['fecha_desde'] = date('Y-m-d', strtotime('monday this week'));
                $filtros['fecha_hasta'] = date('Y-m-d', strtotime('sunday this week'));
                break;
            case 'mes':
                $filtros['fecha_desde'] = date('Y-m-01');
                $filtros['fecha_hasta'] = date('Y-m-t');
                break;
        }
        
        // Obtener datos
        $pedidos = $pedidoModel->getPedidosConFiltros($filtros);
        $total_pedidos = count($pedidos);
        $pedidos_entregados = count(array_filter($pedidos, fn($p) => $p['estado'] === 'entregado'));
        $pedidos_en_camino = count(array_filter($pedidos, fn($p) => $p['estado'] === 'en_camino'));
        $ingresos_totales = array_sum(array_column($pedidos, 'total'));
        
        // Calcular tiempos promedio
        $tiempo_preparacion = $this->calcularTiempoPromedio($pedidos, 'preparacion');
        $tiempo_entrega = $this->calcularTiempoPromedio($pedidos, 'entrega');
        
        // Agrupar por zonas
        $zonas = $this->agruparPorZonas($pedidos);
        
        return view('admin/estadisticas_mapa', [
            'pedidos' => $pedidos,
            'total_pedidos' => $total_pedidos,
            'pedidos_entregados' => $pedidos_entregados,
            'pedidos_en_camino' => $pedidos_en_camino,
            'ingresos_totales' => $ingresos_totales,
            'tiempo_preparacion' => $tiempo_preparacion,
            'tiempo_entrega' => $tiempo_entrega,
            'zonas' => $zonas,
            'periodo' => $periodo,
            'estado' => $estado,
            'fecha_desde' => $fecha_desde,
            'fecha_hasta' => $fecha_hasta
        ]);
    }
    
    /**
     * Calcular tiempo promedio de preparación o entrega
     */
    private function calcularTiempoPromedio($pedidos, $tipo)
    {
        $tiempos = [];
        
        foreach ($pedidos as $pedido) {
            if ($tipo === 'preparacion' && isset($pedido['fecha_listo'])) {
                $inicio = strtotime($pedido['fecha']);
                $fin = strtotime($pedido['fecha_listo']);
                if ($inicio && $fin) {
                    $tiempos[] = ($fin - $inicio) / 60; // en minutos
                }
            } elseif ($tipo === 'entrega' && isset($pedido['fecha_entrega'])) {
                $inicio = strtotime($pedido['fecha_listo'] ?? $pedido['fecha']);
                $fin = strtotime($pedido['fecha_entrega']);
                if ($inicio && $fin) {
                    $tiempos[] = ($fin - $inicio) / 60; // en minutos
                }
            }
        }
        
        return count($tiempos) > 0 ? round(array_sum($tiempos) / count($tiempos)) : 0;
    }
    
    /**
     * Agrupar pedidos por zonas geográficas
     */
    private function agruparPorZonas($pedidos)
    {
        $zonas = [];
        
        foreach ($pedidos as $pedido) {
            if (!empty($pedido['direccion_entrega'])) {
                // Extraer zona de la dirección (simplificado)
                $zona = $this->extraerZona($pedido['direccion_entrega']);
                
                if (!isset($zonas[$zona])) {
                    $zonas[$zona] = [
                        'zona' => $zona,
                        'total' => 0,
                        'ingresos' => 0
                    ];
                }
                
                $zonas[$zona]['total']++;
                $zonas[$zona]['ingresos'] += $pedido['total'];
            }
        }
        
        // Ordenar por total de pedidos
        usort($zonas, function($a, $b) {
            return $b['total'] - $a['total'];
        });
        
        return $zonas;
    }
    
    /**
     * Extraer zona de la dirección
     */
    private function extraerZona($direccion)
    {
        // Simplificado: buscar palabras clave comunes en Clorinda
        $palabras_clave = [
            'centro' => 'Centro',
            'norte' => 'Zona Norte',
            'sur' => 'Zona Sur',
            'este' => 'Zona Este',
            'oeste' => 'Zona Oeste',
            'barrio' => 'Barrios',
            'avenida' => 'Avenidas',
            'calle' => 'Calles'
        ];
        
        $direccion_lower = strtolower($direccion);
        
        foreach ($palabras_clave as $clave => $zona) {
            if (strpos($direccion_lower, $clave) !== false) {
                return $zona;
            }
        }
        
        return 'Otras Zonas';
    }
    
    /**
     * API para obtener datos en formato JSON
     */
    public function api()
    {
        $pedidoModel = new PedidoModel();
        $pedidos = $pedidoModel->getPedidosConFiltros([]);
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $pedidos
        ]);
    }
    
    /**
     * Exportar datos a CSV
     */
    public function exportar()
    {
        $pedidoModel = new PedidoModel();
        $pedidos = $pedidoModel->getPedidosConFiltros([]);
        
        $filename = 'estadisticas_entregas_' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Headers
        fputcsv($output, ['ID', 'Cliente', 'Dirección', 'Estado', 'Total', 'Fecha']);
        
        // Data
        foreach ($pedidos as $pedido) {
            fputcsv($output, [
                $pedido['id'],
                $pedido['nombre'],
                $pedido['direccion_entrega'],
                $pedido['estado'],
                $pedido['total'],
                $pedido['fecha']
            ]);
        }
        
        fclose($output);
        exit;
    }
} 