<?php
namespace App\Controllers;

use App\Models\DetallePedidoModel;
use App\Models\PedidoModel;
use CodeIgniter\Controller;

class DebugController extends Controller
{
    protected $detalleModel;
    protected $pedidoModel;

    public function __construct()
    {
        $this->detalleModel = new DetallePedidoModel();
        $this->pedidoModel = new PedidoModel();
    }

    /**
     * Debug del modelo DetallePedidoModel
     */
    public function debugDetalles($pedido_id = 10)
    {
        echo "<h1>Debug DetallePedidoModel - Pedido #$pedido_id</h1>";
        
        echo "<h2>1. Datos crudos de detalles_pedido</h2>";
        $detalles_crudos = $this->detalleModel->where('pedido_id', $pedido_id)->findAll();
        echo "<pre>";
        print_r($detalles_crudos);
        echo "</pre>";
        
        echo "<h2>2. Datos con JOIN (getDetallesConInfo)</h2>";
        $detalles_con_info = $this->detalleModel->getDetallesConInfo($pedido_id);
        echo "<pre>";
        print_r($detalles_con_info);
        echo "</pre>";
        
        echo "<h2>3. Datos completos (getDetallesCompletos)</h2>";
        $detalles_completos = $this->detalleModel->getDetallesCompletos($pedido_id);
        echo "<pre>";
        print_r($detalles_completos);
        echo "</pre>";
        
        echo "<h2>4. Consulta SQL directa</h2>";
        $builder = $this->detalleModel->db->table('detalles_pedido dp');
        $builder->select('dp.*, p.nombre as producto_nombre, p.imagen as producto_imagen, c.nombre as combo_nombre, c.imagen as combo_imagen');
        $builder->join('productos p', 'p.id = dp.producto_id', 'left');
        $builder->join('combos c', 'c.id = dp.combo_id', 'left');
        $builder->where('dp.pedido_id', $pedido_id);
        
        $query = $builder->getCompiledSelect();
        echo "<strong>SQL Query:</strong><br>";
        echo "<code>$query</code><br><br>";
        
        $result = $builder->get()->getResultArray();
        echo "<strong>Resultado:</strong><br>";
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        
        echo "<h2>5. Verificar productos disponibles</h2>";
        $productos = $this->detalleModel->db->table('productos')->select('id, nombre')->get()->getResultArray();
        echo "<pre>";
        print_r($productos);
        echo "</pre>";
        
        echo "<h2>6. Verificar combos disponibles</h2>";
        $combos = $this->detalleModel->db->table('combos')->select('id, nombre')->get()->getResultArray();
        echo "<pre>";
        print_r($combos);
        echo "</pre>";
        
        echo "<h2>7. Información del pedido</h2>";
        $pedido = $this->pedidoModel->find($pedido_id);
        echo "<pre>";
        print_r($pedido);
        echo "</pre>";
        
        echo "<h2>8. Datos con información mejorada (getDetallesConInfoMejorada)</h2>";
        $detalles_mejorados = $this->detalleModel->getDetallesConInfoMejorada($pedido_id);
        echo "<pre>";
        print_r($detalles_mejorados);
        echo "</pre>";
    }

    /**
     * Debug de todos los pedidos
     */
    public function debugTodosPedidos()
    {
        echo "<h1>Debug - Todos los Pedidos</h1>";
        
        $pedidos = $this->pedidoModel->findAll();
        echo "<h2>Lista de pedidos:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Estado</th><th>Fecha</th></tr>";
        foreach ($pedidos as $pedido) {
            echo "<tr>";
            echo "<td>{$pedido['id']}</td>";
            echo "<td>{$pedido['nombre']}</td>";
            echo "<td>{$pedido['estado']}</td>";
            echo "<td>{$pedido['fecha']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<h2>Detalles de cada pedido:</h2>";
        foreach ($pedidos as $pedido) {
            $detalles = $this->detalleModel->getDetallesConInfo($pedido['id']);
            echo "<h3>Pedido #{$pedido['id']} - {$pedido['nombre']}</h3>";
            echo "<pre>";
            print_r($detalles);
            echo "</pre>";
        }
    }

    /**
     * Debug de estructura de tablas
     */
    public function debugEstructura()
    {
        echo "<h1>Debug - Estructura de Tablas</h1>";
        
        echo "<h2>Estructura de detalles_pedido:</h2>";
        $estructura_detalles = $this->detalleModel->db->query("DESCRIBE detalles_pedido")->getResultArray();
        echo "<pre>";
        print_r($estructura_detalles);
        echo "</pre>";
        
        echo "<h2>Estructura de productos:</h2>";
        $estructura_productos = $this->detalleModel->db->query("DESCRIBE productos")->getResultArray();
        echo "<pre>";
        print_r($estructura_productos);
        echo "</pre>";
        
        echo "<h2>Estructura de combos:</h2>";
        $estructura_combos = $this->detalleModel->db->query("DESCRIBE combos")->getResultArray();
        echo "<pre>";
        print_r($estructura_combos);
        echo "</pre>";
    }
} 