<?php
namespace App\Controllers;

use App\Models\PedidoModel;
use App\Models\DetallePedidoModel;
use CodeIgniter\Controller;

/**
 * Controlador para el dashboard de estadísticas y reportes.
 */
class EstadisticasController extends Controller
{
    /**
     * Muestra el dashboard de estadísticas generales.
     */
    public function dashboard()
    {
        $pedidoModel = new PedidoModel();
        $detalleModel = new DetallePedidoModel();
        $productoModel = new \App\Models\ProductoModel();
        $productos = $productoModel->getAllActivos();
        $repartidorModel = new \App\Models\RepartidorModel();
        $repartidores = $repartidorModel->listarActivos();
        $repartidor_id = $this->request->getGet('repartidor_id');

        // Filtros por fecha, producto y repartidor
        $desde = $this->request->getGet('desde');
        $hasta = $this->request->getGet('hasta');
        $producto_id = $this->request->getGet('producto_id');
        $where = [];
        if ($desde) {
            $where['fecha >='] = $desde . ' 00:00:00';
        }
        if ($hasta) {
            $where['fecha <='] = $hasta . ' 23:59:59';
        }
        if ($repartidor_id) {
            $where['repartidor_id'] = $repartidor_id;
        }
        $pedidos = empty($where) ? $pedidoModel->findAll() : $pedidoModel->where($where)->findAll();
        $totalVentas = 0;
        $cantidadPedidos = count($pedidos);
        $idsPedidos = [];
        foreach ($pedidos as $p) {
            $totalVentas += $p['total'];
            $idsPedidos[] = $p['id'];
        }

        // Productos más pedidos (solo en pedidos filtrados y producto seleccionado)
        $productosMasPedidos = [];
        if ($idsPedidos) {
            $db = \Config\Database::connect();
            $idsStr = implode(',', $idsPedidos);
            $whereProducto = $producto_id ? 'AND producto_id = ' . intval($producto_id) : '';
            $productosMasPedidos = $db->query('
                SELECT producto_id, COUNT(*) as cantidad, SUM(cantidad) as total_cant
                FROM detalles_pedido
                WHERE producto_id IS NOT NULL ' . $whereProducto . ' AND pedido_id IN (' . $idsStr . ')
                GROUP BY producto_id
                ORDER BY total_cant DESC
                LIMIT 5
            ')->getResultArray();
        }

        // Procesar datos de productos para la vista
        $top_productos = [];
        $total_ventas_productos = 0;
        
        foreach ($productosMasPedidos as $prod) {
            $producto = $productoModel->getById($prod['producto_id']);
            if ($producto) {
                $total_ventas_productos += $prod['total_cant'] * $producto['precio'];
                $top_productos[] = [
                    'id' => $prod['producto_id'],
                    'nombre' => $producto['nombre'],
                    'descripcion' => $producto['descripcion'] ?? '',
                    'imagen' => $producto['imagen'] ?? '',
                    'cantidad_vendida' => $prod['total_cant'],
                    'total_ventas' => $prod['total_cant'] * $producto['precio'],
                    'porcentaje' => 0, // Se calculará después
                    'tendencia' => 0 // Se puede implementar después
                ];
            }
        }
        
        // Calcular porcentajes
        if ($total_ventas_productos > 0) {
            foreach ($top_productos as &$prod) {
                $prod['porcentaje'] = ($prod['total_ventas'] / $total_ventas_productos) * 100;
            }
        }

        $ganancias = $totalVentas;

        // Ventas por día (para gráfico)
        $ventasPorDia = [];
        foreach ($pedidos as $p) {
            $fecha = substr($p['fecha'], 0, 10);
            if (!isset($ventasPorDia[$fecha])) {
                $ventasPorDia[$fecha] = 0;
            }
            $ventasPorDia[$fecha] += $p['total'];
        }
        ksort($ventasPorDia);

        // Calcular métricas adicionales
        $promedio_pedido = $cantidadPedidos > 0 ? round($totalVentas / $cantidadPedidos, 0) : 0;
        
        // Calcular pedidos por día
        $dias_periodo = 1;
        if ($desde && $hasta) {
            $dias_periodo = max(1, (strtotime($hasta) - strtotime($desde)) / (24 * 60 * 60) + 1);
        }
        $pedidos_por_dia = round($cantidadPedidos / $dias_periodo, 1);
        
        // Calcular productos por pedido (simulado)
        $productos_por_pedido = 2.5; // Valor promedio
        
        // Tiempo de entrega promedio (simulado)
        $tiempo_entrega_promedio = 35; // minutos
        
        // Actividad reciente (simulada)
        $actividad_reciente = [
            [
                'titulo' => 'Pedido #' . ($pedidos[0]['codigo_seguimiento'] ?? 'PED123') . ' entregado',
                'fecha' => date('d/m/Y H:i', strtotime($pedidos[0]['fecha'] ?? 'now'))
            ],
            [
                'titulo' => 'Nuevo pedido recibido',
                'fecha' => date('d/m/Y H:i', strtotime('-1 hour'))
            ],
            [
                'titulo' => 'Repartidor asignado a pedido',
                'fecha' => date('d/m/Y H:i', strtotime('-2 hours'))
            ]
        ];
        
        // Preparar datos para gráficos
        $ventas_por_dia_labels = array_keys($ventasPorDia);
        $ventas_por_dia_data = array_values($ventasPorDia);
        
        $productos_labels = array_column($top_productos, 'nombre');
        $productos_data = array_column($top_productos, 'cantidad_vendida');

        // Obtener pedidos recientes (últimos 10 pedidos)
        $pedidos_recientes = $pedidoModel->orderBy('fecha', 'DESC')->limit(10)->findAll();
        
        // Calcular clientes únicos de manera más precisa
        $clientes_unicos = $this->calcularClientesUnicos($pedidos);
        
        // Obtener estadísticas adicionales de clientes
        $estadisticas_clientes = $this->obtenerEstadisticasClientes($pedidos);
        
        // Obtener estadísticas de rangos horarios
        $rangos_horarios = $this->obtenerRangosHorarios($pedidos);
        
        // Obtener estadísticas de barrios/zonas
        $estadisticas_zonas = $this->obtenerEstadisticasZonas($pedidos);
        
        // Obtener estadísticas de distancias
        $estadisticas_distancias = $this->obtenerEstadisticasDistancias($pedidos);
        
        // Obtener coordenadas individuales de todos los pedidos
        $coordenadas_pedidos = $this->obtenerCoordenadasPedidos($pedidos);
        
        // Preparar datos para gráfico de ventas
        $datos_ventas = [];
        foreach ($ventasPorDia as $fecha => $total) {
            $datos_ventas[] = [
                'fecha' => date('d/m/Y', strtotime($fecha)),
                'total' => $total
            ];
        }
        
        // Preparar datos para gráfico de productos
        $productos_mas_vendidos = [];
        foreach ($top_productos as $producto) {
            $productos_mas_vendidos[] = [
                'nombre' => $producto['nombre'],
                'cantidad' => $producto['cantidad_vendida']
            ];
        }
        
        $data = [
            'title' => 'Estadísticas y Reportes',
            'ventas_totales' => $totalVentas,
            'total_pedidos' => $cantidadPedidos,
            'ganancias_estimadas' => $ganancias,
            'clientes_unicos' => $clientes_unicos,
            'promedio_pedido' => $promedio_pedido,
            'pedidos_por_dia' => $pedidos_por_dia,
            'productos_por_pedido' => $productos_por_pedido,
            'tiempo_entrega_promedio' => $tiempo_entrega_promedio,
            'actividad_reciente' => $actividad_reciente,
            'top_productos' => $top_productos,
            'pedidos_recientes' => $pedidos_recientes,
            'datos_ventas' => $datos_ventas,
            'productos_mas_vendidos' => $productos_mas_vendidos,
            'desde' => $desde,
            'hasta' => $hasta,
            'fecha_desde' => $desde,
            'fecha_hasta' => $hasta,
            'producto_id' => $producto_id,
            'producto_filtro' => $producto_id,
            'productos' => $productos,
            'repartidor_id' => $repartidor_id,
            'repartidor_filtro' => $repartidor_id,
            'repartidores' => $repartidores,
            'ventasPorDia' => $ventasPorDia,
            'ventas_por_dia_labels' => $ventas_por_dia_labels,
            'ventas_por_dia_data' => $ventas_por_dia_data,
            'productos_labels' => $productos_labels,
            'productos_data' => $productos_data,
            'estadisticas_clientes' => $estadisticas_clientes,
            'rangos_horarios' => $rangos_horarios,
            'estadisticas_zonas' => $estadisticas_zonas,
            'estadisticas_distancias' => $estadisticas_distancias,
            'coordenadas_pedidos' => $coordenadas_pedidos
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/estadisticas_dashboard', $data)
            . view('footer_admin');
    }
    
    /**
     * Calcula clientes únicos usando múltiples criterios para mayor precisión
     */
    private function calcularClientesUnicos($pedidos)
    {
        if (empty($pedidos)) {
            return 0;
        }
        
        $clientes_unicos = [];
        
        foreach ($pedidos as $pedido) {
            // Crear un identificador único combinando múltiples campos
            $identificador_cliente = $this->crearIdentificadorCliente($pedido);
            
            if (!empty($identificador_cliente)) {
                $clientes_unicos[$identificador_cliente] = [
                    'nombre' => $pedido['nombre'] ?? '',
                    'correo' => $pedido['correo_electronico'] ?? '',
                    'telefono' => $pedido['telefono'] ?? '',
                    'pedidos' => 0
                ];
            }
        }
        
        // Contar pedidos por cliente
        foreach ($pedidos as $pedido) {
            $identificador = $this->crearIdentificadorCliente($pedido);
            if (isset($clientes_unicos[$identificador])) {
                $clientes_unicos[$identificador]['pedidos']++;
            }
        }
        
        return count($clientes_unicos);
    }
    
    /**
     * Crea un identificador único para cada cliente
     */
    private function crearIdentificadorCliente($pedido)
    {
        $identificadores = [];
        
        // 1. Por correo electrónico (si existe)
        if (!empty($pedido['correo_electronico'])) {
            $identificadores[] = 'email:' . strtolower(trim($pedido['correo_electronico']));
        }
        
        // 2. Por teléfono (si existe)
        if (!empty($pedido['telefono'])) {
            $telefono_limpio = preg_replace('/[^0-9]/', '', $pedido['telefono']);
            if (strlen($telefono_limpio) >= 8) {
                $identificadores[] = 'phone:' . $telefono_limpio;
            }
        }
        
        // 3. Por nombre + teléfono (si ambos existen)
        if (!empty($pedido['nombre']) && !empty($pedido['telefono'])) {
            $nombre_limpio = strtolower(trim($pedido['nombre']));
            $telefono_limpio = preg_replace('/[^0-9]/', '', $pedido['telefono']);
            if (strlen($telefono_limpio) >= 8) {
                $identificadores[] = 'name_phone:' . $nombre_limpio . '_' . $telefono_limpio;
            }
        }
        
        // 4. Por nombre + correo (si ambos existen)
        if (!empty($pedido['nombre']) && !empty($pedido['correo_electronico'])) {
            $nombre_limpio = strtolower(trim($pedido['nombre']));
            $email_limpio = strtolower(trim($pedido['correo_electronico']));
            $identificadores[] = 'name_email:' . $nombre_limpio . '_' . $email_limpio;
        }
        
        // Si no hay identificadores válidos, usar solo el nombre
        if (empty($identificadores) && !empty($pedido['nombre'])) {
            $identificadores[] = 'name:' . strtolower(trim($pedido['nombre']));
        }
        
        // Retornar el primer identificador válido
        return !empty($identificadores) ? $identificadores[0] : null;
    }
    
    /**
     * Obtiene estadísticas adicionales sobre los clientes
     */
    private function obtenerEstadisticasClientes($pedidos)
    {
        if (empty($pedidos)) {
            return [
                'clientes_unicos' => 0,
                'promedio_pedidos_por_cliente' => 0,
                'cliente_mas_activo' => null,
                'nuevos_clientes_hoy' => 0,
                'clientes_recurrentes' => 0
            ];
        }
        
        $clientes = [];
        $hoy = date('Y-m-d');
        
        foreach ($pedidos as $pedido) {
            $identificador = $this->crearIdentificadorCliente($pedido);
            
            if (!empty($identificador)) {
                if (!isset($clientes[$identificador])) {
                    $clientes[$identificador] = [
                        'nombre' => $pedido['nombre'] ?? '',
                        'correo' => $pedido['correo_electronico'] ?? '',
                        'telefono' => $pedido['telefono'] ?? '',
                        'pedidos' => 0,
                        'total_gastado' => 0,
                        'primer_pedido' => $pedido['fecha'],
                        'ultimo_pedido' => $pedido['fecha']
                    ];
                }
                
                $clientes[$identificador]['pedidos']++;
                $clientes[$identificador]['total_gastado'] += $pedido['total'];
                
                if (strtotime($pedido['fecha']) < strtotime($clientes[$identificador]['primer_pedido'])) {
                    $clientes[$identificador]['primer_pedido'] = $pedido['fecha'];
                }
                
                if (strtotime($pedido['fecha']) > strtotime($clientes[$identificador]['ultimo_pedido'])) {
                    $clientes[$identificador]['ultimo_pedido'] = $pedido['fecha'];
                }
            }
        }
        
        // Calcular estadísticas
        $total_clientes = count($clientes);
        $total_pedidos = array_sum(array_column($clientes, 'pedidos'));
        $promedio_pedidos = $total_clientes > 0 ? round($total_pedidos / $total_clientes, 1) : 0;
        
        // Cliente más activo
        $cliente_mas_activo = null;
        $max_pedidos = 0;
        foreach ($clientes as $cliente) {
            if ($cliente['pedidos'] > $max_pedidos) {
                $max_pedidos = $cliente['pedidos'];
                $cliente_mas_activo = $cliente;
            }
        }
        
        // Nuevos clientes hoy
        $nuevos_hoy = 0;
        foreach ($clientes as $cliente) {
            if (date('Y-m-d', strtotime($cliente['primer_pedido'])) === $hoy) {
                $nuevos_hoy++;
            }
        }
        
        // Clientes recurrentes (más de 1 pedido)
        $recurrentes = 0;
        foreach ($clientes as $cliente) {
            if ($cliente['pedidos'] > 1) {
                $recurrentes++;
            }
        }
        
                 return [
             'clientes_unicos' => $total_clientes,
             'promedio_pedidos_por_cliente' => $promedio_pedidos,
             'cliente_mas_activo' => $cliente_mas_activo,
             'nuevos_clientes_hoy' => $nuevos_hoy,
             'clientes_recurrentes' => $recurrentes,
             'total_pedidos' => $total_pedidos
         ];
     }
     
     /**
      * Obtiene estadísticas de rangos horarios más pedidos
      */
     private function obtenerRangosHorarios($pedidos)
     {
         if (empty($pedidos)) {
             return [
                 'rangos' => [],
                 'horario_pico' => null,
                 'horario_valle' => null
             ];
         }
         
         $rangos = [
             '06:00-09:00' => 0,
             '09:00-12:00' => 0,
             '12:00-15:00' => 0,
             '15:00-18:00' => 0,
             '18:00-21:00' => 0,
             '21:00-00:00' => 0,
             '00:00-06:00' => 0
         ];
         
         foreach ($pedidos as $pedido) {
             $hora = (int)date('H', strtotime($pedido['fecha']));
             
             if ($hora >= 6 && $hora < 9) {
                 $rangos['06:00-09:00']++;
             } elseif ($hora >= 9 && $hora < 12) {
                 $rangos['09:00-12:00']++;
             } elseif ($hora >= 12 && $hora < 15) {
                 $rangos['12:00-15:00']++;
             } elseif ($hora >= 15 && $hora < 18) {
                 $rangos['15:00-18:00']++;
             } elseif ($hora >= 18 && $hora < 21) {
                 $rangos['18:00-21:00']++;
             } elseif ($hora >= 21) {
                 $rangos['21:00-00:00']++;
             } else {
                 $rangos['00:00-06:00']++;
             }
         }
         
         // Encontrar horario pico y valle
         $max_pedidos = max($rangos);
         $min_pedidos = min($rangos);
         $horario_pico = array_search($max_pedidos, $rangos);
         $horario_valle = array_search($min_pedidos, $rangos);
         
         return [
             'rangos' => $rangos,
             'horario_pico' => $horario_pico,
             'horario_valle' => $horario_valle,
             'max_pedidos' => $max_pedidos,
             'min_pedidos' => $min_pedidos
         ];
     }
     
         /**
     * Obtiene estadísticas de barrios/zonas con más pedidos
     */
    private function obtenerEstadisticasZonas($pedidos)
    {
        if (empty($pedidos)) {
            return [
                'zonas' => [],
                'zona_mas_activa' => null,
                'total_zonas' => 0
            ];
        }
        
        $zonas = [];
        
        foreach ($pedidos as $pedido) {
            $direccion = $pedido['direccion'] ?? '';
            $zona = $this->extraerZona($direccion);
            
            if (!empty($zona)) {
                if (!isset($zonas[$zona])) {
                    $zonas[$zona] = [
                        'nombre' => $zona,
                        'pedidos' => 0,
                        'total_ventas' => 0,
                        'promedio_pedido' => 0,
                        'coordenadas' => $this->obtenerCoordenadasZona($zona)
                    ];
                }
                
                $zonas[$zona]['pedidos']++;
                $zonas[$zona]['total_ventas'] += $pedido['total'];
            }
        }
        
        // Calcular promedio por zona
        foreach ($zonas as &$zona) {
            $zona['promedio_pedido'] = round($zona['total_ventas'] / $zona['pedidos'], 0);
        }
        
        // Ordenar por número de pedidos
        uasort($zonas, function($a, $b) {
            return $b['pedidos'] - $a['pedidos'];
        });
        
        $zona_mas_activa = !empty($zonas) ? array_values($zonas)[0] : null;
        
        return [
            'zonas' => array_values($zonas),
            'zona_mas_activa' => $zona_mas_activa,
            'total_zonas' => count($zonas)
        ];
    }
     
         /**
     * Extrae la zona/barrio de una dirección
     */
    private function extraerZona($direccion)
    {
        // Lista de zonas comunes
        $zonas_comunes = [
            'centro', 'norte', 'sur', 'este', 'oeste', 'este', 'oeste',
            'microcentro', 'palermo', 'recoleta', 'belgrano', 'caballito',
            'villa crespo', 'villa del parque', 'villa santa rita',
            'flores', 'floresta', 'villa luro', 'mataderos', 'liniers',
            'villa real', 'villa devoto', 'villa pueyrredon', 'agronomia',
            'parque chacabuco', 'boedo', 'san cristobal', 'balvanera',
            'monserrat', 'san nicolas', 'puerto madero', 'retiro',
            'san telmo', 'la boca', 'barracas', 'parque patricios'
        ];
        
        $direccion_lower = strtolower($direccion);
        
        foreach ($zonas_comunes as $zona) {
            if (strpos($direccion_lower, $zona) !== false) {
                return ucfirst($zona);
            }
        }
        
        // Si no encuentra zona específica, intentar extraer del final de la dirección
        $partes = explode(',', $direccion);
        if (count($partes) > 1) {
            $ultima_parte = trim(end($partes));
            if (!empty($ultima_parte)) {
                return ucfirst(strtolower($ultima_parte));
            }
        }
        
        return 'Zona no identificada';
    }
    
    /**
     * Obtiene coordenadas reales para cada zona de Buenos Aires
     */
    private function obtenerCoordenadasZona($zona)
    {
        // Coordenadas reales de zonas de Clorinda, Formosa
        $coordenadas_zonas = [
            'Clorinda' => ['lat' => -25.2847, 'lng' => -57.7185],

        ];
        
        // Buscar la zona exacta
        if (isset($coordenadas_zonas[$zona])) {
            return $coordenadas_zonas[$zona];
        }
        
        // Si no encuentra la zona exacta, buscar por similitud
        $zona_lower = strtolower($zona);
        foreach ($coordenadas_zonas as $nombre_zona => $coords) {
            if (strpos(strtolower($nombre_zona), $zona_lower) !== false || 
                strpos($zona_lower, strtolower($nombre_zona)) !== false) {
                return $coords;
            }
        }
        
        // Si no encuentra nada, devolver coordenadas del centro de Clorinda
        return ['lat' => -25.2847, 'lng' => -57.7185];
    }
     
     /**
      * Obtiene estadísticas de distancias de los pedidos
      */
     private function obtenerEstadisticasDistancias($pedidos)
     {
         if (empty($pedidos)) {
             return [
                 'distancia_promedio' => 0,
                 'distancia_maxima' => 0,
                 'distancia_minima' => 0,
                 'pedidos_cerca' => 0,
                 'pedidos_lejos' => 0,
                 'valor_promedio_pedido' => 0,
                 'valor_maximo_pedido' => 0,
                 'valor_minimo_pedido' => 0
             ];
         }
         
         $distancias = [];
         $valores = [];
         
         foreach ($pedidos as $pedido) {
             // Calcular distancia (simulado - en producción usar API de Google Maps)
             $distancia = $this->calcularDistancia($pedido);
             if ($distancia > 0) {
                 $distancias[] = $distancia;
             }
             
             $valores[] = $pedido['total'];
         }
         
         $distancia_promedio = !empty($distancias) ? round(array_sum($distancias) / count($distancias), 1) : 0;
         $distancia_maxima = !empty($distancias) ? max($distancias) : 0;
         $distancia_minima = !empty($distancias) ? min($distancias) : 0;
         
         $pedidos_cerca = count(array_filter($distancias, function($d) { return $d <= 5; }));
         $pedidos_lejos = count(array_filter($distancias, function($d) { return $d > 10; }));
         
         $valor_promedio = round(array_sum($valores) / count($valores), 0);
         $valor_maximo = max($valores);
         $valor_minimo = min($valores);
         
         return [
             'distancia_promedio' => $distancia_promedio,
             'distancia_maxima' => $distancia_maxima,
             'distancia_minima' => $distancia_minima,
             'pedidos_cerca' => $pedidos_cerca,
             'pedidos_lejos' => $pedidos_lejos,
             'valor_promedio_pedido' => $valor_promedio,
             'valor_maximo_pedido' => $valor_maximo,
             'valor_minimo_pedido' => $valor_minimo,
             'total_pedidos' => count($pedidos)
         ];
     }
     
     /**
      * Calcula la distancia del pedido (simulado)
      */
     private function calcularDistancia($pedido)
     {
         // En producción, usar Google Maps API para calcular distancia real
         // Por ahora, simulamos basándonos en la dirección
         $direccion = $pedido['direccion'] ?? '';
         
         if (empty($direccion)) {
             return rand(2, 15); // Distancia aleatoria entre 2-15 km
         }
         
         // Simular distancia basada en palabras clave en la dirección
         $palabras_clave = [
             'centro' => 1,
             'microcentro' => 1,
             'palermo' => 3,
             'recoleta' => 2,
             'belgrano' => 5,
             'caballito' => 4,
             'flores' => 6,
             'mataderos' => 8,
             'villa' => 7,
             'norte' => 4,
             'sur' => 6,
             'este' => 5,
             'oeste' => 7
         ];
         
         $direccion_lower = strtolower($direccion);
         
         foreach ($palabras_clave as $palabra => $distancia) {
             if (strpos($direccion_lower, $palabra) !== false) {
                 return $distancia + rand(0, 3); // Agregar variación
             }
         }
         
         return rand(3, 12); // Distancia aleatoria por defecto
     }

    /**
     * Obtiene las coordenadas individuales de todos los pedidos
     */
    private function obtenerCoordenadasPedidos($pedidos)
    {
        $coordenadas = [];
        
        foreach ($pedidos as $pedido) {
            // Verificar si el pedido tiene coordenadas reales
            if (!empty($pedido['latitud']) && !empty($pedido['longitud'])) {
                $coordenadas[] = [
                    'id' => $pedido['id'],
                    'nombre' => $pedido['nombre'] ?? 'Cliente',
                    'direccion' => $pedido['direccion_entrega'] ?? '',
                    'total' => $pedido['total'] ?? 0,
                    'fecha' => $pedido['fecha'] ?? '',
                    'lat' => floatval($pedido['latitud']),
                    'lng' => floatval($pedido['longitud']),
                    'estado' => $pedido['estado'] ?? 'pendiente'
                ];
            } else {
                // Si no tiene coordenadas reales, generar coordenadas simuladas basadas en la dirección
                $coordenadas_simuladas = $this->generarCoordenadasSimuladas($pedido);
                if ($coordenadas_simuladas) {
                    $coordenadas[] = [
                        'id' => $pedido['id'],
                        'nombre' => $pedido['nombre'] ?? 'Cliente',
                        'direccion' => $pedido['direccion_entrega'] ?? '',
                        'total' => $pedido['total'] ?? 0,
                        'fecha' => $pedido['fecha'] ?? '',
                        'lat' => $coordenadas_simuladas['lat'],
                        'lng' => $coordenadas_simuladas['lng'],
                        'estado' => $pedido['estado'] ?? 'pendiente'
                    ];
                }
            }
        }
        
        return $coordenadas;
    }

    /**
     * Genera coordenadas simuladas basadas en la dirección del pedido
     */
    private function generarCoordenadasSimuladas($pedido)
    {
        $direccion = $pedido['direccion_entrega'] ?? '';
        
        if (empty($direccion)) {
            // Si no hay dirección, usar coordenadas del centro de Clorinda
            return [
                'lat' => -25.2847 + (rand(-10, 10) / 1000), // Variación de ±0.01 grados
                'lng' => -57.7185 + (rand(-10, 10) / 1000)
            ];
        }
        
        // Coordenadas base de Clorinda
        $base_lat = -25.2847;
        $base_lng = -57.7185;
        
        // Simular coordenadas basadas en palabras clave en la dirección
        $direccion_lower = strtolower($direccion);
        
        // Zonas específicas de Clorinda con coordenadas aproximadas
        $zonas_coordenadas = [
            'centro' => ['lat_offset' => 0, 'lng_offset' => 0],
            'microcentro' => ['lat_offset' => 0, 'lng_offset' => 0],
            'villa del carmen' => ['lat_offset' => -0.005, 'lng_offset' => 0.002],
            'villa del rosario' => ['lat_offset' => 0.005, 'lng_offset' => -0.004],
            'villa del pilar' => ['lat_offset' => 0.010, 'lng_offset' => 0.007],
            'norte' => ['lat_offset' => 0.015, 'lng_offset' => 0],
            'sur' => ['lat_offset' => -0.015, 'lng_offset' => 0],
            'este' => ['lat_offset' => 0, 'lng_offset' => -0.008],
            'oeste' => ['lat_offset' => 0, 'lng_offset' => 0.012],
            'barrio' => ['lat_offset' => 0.005, 'lng_offset' => 0.003]
        ];
        
        foreach ($zonas_coordenadas as $zona => $offset) {
            if (strpos($direccion_lower, $zona) !== false) {
                return [
                    'lat' => $base_lat + $offset['lat_offset'] + (rand(-5, 5) / 1000),
                    'lng' => $base_lng + $offset['lng_offset'] + (rand(-5, 5) / 1000)
                ];
            }
        }
        
        // Si no coincide con ninguna zona específica, generar coordenadas aleatorias cerca del centro
        return [
            'lat' => $base_lat + (rand(-20, 20) / 1000),
            'lng' => $base_lng + (rand(-20, 20) / 1000)
        ];
    }

    /**
     * Exporta los productos más pedidos filtrados a un archivo CSV.
     */
    public function exportarExcel()
    {
        $pedidoModel = new \App\Models\PedidoModel();
        $productoModel = new \App\Models\ProductoModel();
        $repartidorModel = new \App\Models\RepartidorModel();

        $desde = $this->request->getGet('desde');
        $hasta = $this->request->getGet('hasta');
        $producto_id = $this->request->getGet('producto_id');
        $repartidor_id = $this->request->getGet('repartidor_id');
        $where = [];
        if ($desde) {
            $where['fecha >='] = $desde . ' 00:00:00';
        }
        if ($hasta) {
            $where['fecha <='] = $hasta . ' 23:59:59';
        }
        if ($repartidor_id) {
            $where['repartidor_id'] = $repartidor_id;
        }
        $pedidos = empty($where) ? $pedidoModel->findAll() : $pedidoModel->where($where)->findAll();
        $idsPedidos = [];
        foreach ($pedidos as $p) {
            $idsPedidos[] = $p['id'];
        }
        $productosMasPedidos = [];
        if ($idsPedidos) {
            $db = \Config\Database::connect();
            $idsStr = implode(',', $idsPedidos);
            $whereProducto = $producto_id ? 'AND producto_id = ' . intval($producto_id) : '';
            $productosMasPedidos = $db->query('
                SELECT producto_id, COUNT(*) as cantidad, SUM(cantidad) as total_cant
                FROM detalles_pedido
                WHERE producto_id IS NOT NULL ' . $whereProducto . ' AND pedido_id IN (' . $idsStr . ')
                GROUP BY producto_id
                ORDER BY total_cant DESC
            ')->getResultArray();
        }

        // Encabezados para descarga CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=estadisticas_productos.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID Producto', 'Nombre', 'Cantidad de pedidos', 'Total de unidades']);
        foreach ($productosMasPedidos as $prod) {
            $nombre = $productoModel->getById($prod['producto_id'])['nombre'] ?? $prod['producto_id'];
            fputcsv($output, [
                $prod['producto_id'],
                $nombre,
                $prod['cantidad'],
                $prod['total_cant']
            ]);
        }
        fclose($output);
        exit;
    }
} 