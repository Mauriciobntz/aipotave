<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TarifaEnvioModel;

class TarifasEnvioController extends BaseController
{
    protected $tarifaEnvioModel;

    public function __construct()
    {
        $this->tarifaEnvioModel = new TarifaEnvioModel();
    }

    /**
     * Lista todas las tarifas de envío
     */
    public function index()
    {
        $page = $this->request->getGet('page') ?? 1;
        $filtros = [
            'nombre' => $this->request->getGet('nombre'),
            'activo' => $this->request->getGet('activo')
        ];

        $data = $this->tarifaEnvioModel->getConPaginacion($page, 20, $filtros);
        
        // Agregar el objeto request a los datos
        $data['request'] = $this->request;
        
        return view('header', ['title' => 'Tarifas Locales de Envío | Admin'])
            . view('navbar')
            . view('admin/tarifas_envio/index', $data)
            . view('footer');
    }

    /**
     * Muestra el formulario para crear una nueva tarifa
     */
    public function crear()
    {
        $data = [
            'title' => 'Crear Tarifa Local de Envío | Admin',
            'siguienteOrden' => $this->tarifaEnvioModel->getSiguienteOrden()
        ];

        return view('header', $data)
            . view('navbar')
            . view('admin/tarifas_envio/form', $data)
            . view('footer');
    }

    /**
     * Guarda una nueva tarifa de envío
     */
    public function guardar()
    {
        $request = $this->request;
        
        // Validar datos
        $rules = [
            'nombre' => 'required|max_length[100]',
            'distancia_minima' => 'required|numeric|greater_than_equal_to[0]',
            'distancia_maxima' => 'required|numeric|greater_than[0]',
            'costo' => 'required|numeric|greater_than_equal_to[0]',
            'descripcion' => 'permit_empty|max_length[255]',
            'activo' => 'required|in_list[0,1]',
            'orden' => 'required|integer|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $distanciaMinima = $request->getPost('distancia_minima');
        $distanciaMaxima = $request->getPost('distancia_maxima');

        // Verificar que la distancia máxima sea mayor que la mínima
        if ($distanciaMaxima <= $distanciaMinima) {
            return redirect()->back()->withInput()->with('error', 'La distancia máxima debe ser mayor que la distancia mínima.');
        }

        $data = [
            'nombre' => $request->getPost('nombre'),
            'distancia_minima' => $distanciaMinima,
            'distancia_maxima' => $distanciaMaxima,
            'costo' => $request->getPost('costo'),
            'descripcion' => $request->getPost('descripcion'),
            'activo' => $request->getPost('activo'),
            'orden' => $request->getPost('orden')
        ];

        if ($this->tarifaEnvioModel->insert($data)) {
            return redirect()->to('admin/tarifas-envio')->with('success', 'Tarifa local de envío creada exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al crear la tarifa local de envío.');
        }
    }

    /**
     * Muestra el formulario para editar una tarifa
     */
    public function editar($id = null)
    {
        if (!$id) {
            return redirect()->to('admin/tarifas-envio')->with('error', 'ID de tarifa local no especificado.');
        }

        $tarifa = $this->tarifaEnvioModel->find($id);
        
        if (!$tarifa) {
            return redirect()->to('admin/tarifas-envio')->with('error', 'Tarifa local de envío no encontrada.');
        }

        $data = [
            'title' => 'Editar Tarifa Local de Envío | Admin',
            'tarifa' => $tarifa
        ];

        return view('header', $data)
            . view('navbar')
            . view('admin/tarifas_envio/form', $data)
            . view('footer');
    }

    /**
     * Actualiza una tarifa de envío
     */
    public function actualizar($id = null)
    {
        if (!$id) {
            return redirect()->to('admin/tarifas-envio')->with('error', 'ID de tarifa local no especificado.');
        }

        $request = $this->request;
        
        // Validar datos
        $rules = [
            'nombre' => 'required|max_length[100]',
            'distancia_minima' => 'required|numeric|greater_than_equal_to[0]',
            'distancia_maxima' => 'required|numeric|greater_than[0]',
            'costo' => 'required|numeric|greater_than_equal_to[0]',
            'descripcion' => 'permit_empty|max_length[255]',
            'activo' => 'required|in_list[0,1]',
            'orden' => 'required|integer|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $distanciaMinima = $request->getPost('distancia_minima');
        $distanciaMaxima = $request->getPost('distancia_maxima');

        // Verificar que la distancia máxima sea mayor que la mínima
        if ($distanciaMaxima <= $distanciaMinima) {
            return redirect()->back()->withInput()->with('error', 'La distancia máxima debe ser mayor que la distancia mínima.');
        }

        $data = [
            'nombre' => $request->getPost('nombre'),
            'distancia_minima' => $distanciaMinima,
            'distancia_maxima' => $distanciaMaxima,
            'costo' => $request->getPost('costo'),
            'descripcion' => $request->getPost('descripcion'),
            'activo' => $request->getPost('activo'),
            'orden' => $request->getPost('orden')
        ];

        if ($this->tarifaEnvioModel->update($id, $data)) {
            return redirect()->to('admin/tarifas-envio')->with('success', 'Tarifa local de envío actualizada exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar la tarifa local de envío.');
        }
    }

    /**
     * Elimina una tarifa de envío
     */
    public function eliminar($id = null)
    {
        if (!$id) {
            return redirect()->to('admin/tarifas-envio')->with('error', 'ID de tarifa local no especificado.');
        }

        if ($this->tarifaEnvioModel->delete($id)) {
            return redirect()->to('admin/tarifas-envio')->with('success', 'Tarifa local de envío eliminada exitosamente.');
        } else {
            return redirect()->to('admin/tarifas-envio')->with('error', 'Error al eliminar la tarifa local de envío.');
        }
    }

    /**
     * Cambia el estado activo/inactivo de una tarifa
     */
    public function cambiarEstado($id = null)
    {
        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID de tarifa local no especificado.']);
        }

        $tarifa = $this->tarifaEnvioModel->find($id);
        
        if (!$tarifa) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tarifa local de envío no encontrada.']);
        }

        $nuevoEstado = $tarifa['activo'] ? 0 : 1;
        
        if ($this->tarifaEnvioModel->update($id, ['activo' => $nuevoEstado])) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Estado actualizado exitosamente.',
                'nuevo_estado' => $nuevoEstado
            ]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar el estado.']);
        }
    }

    /**
     * API para calcular costo de envío (para usar en el frontend)
     */
    public function calcularCosto()
    {
        try {
            log_message('info', "=== INICIO API calcularCosto ===");
            
            $distancia = $this->request->getPost('distancia');
            log_message('info', "Distancia recibida: " . var_export($distancia, true));
            
            if (!$distancia || !is_numeric($distancia)) {
                log_message('error', "Distancia inválida: {$distancia}");
                return $this->response->setJSON(['success' => false, 'message' => 'Distancia inválida.']);
            }

            log_message('info', "Llamando a calcularCostoEnvio con distancia: {$distancia}");
            $resultado = $this->tarifaEnvioModel->calcularCostoEnvio($distancia);
            
            log_message('info', "Resultado del cálculo: " . json_encode($resultado));
            
            $response = [
                'success' => true,
                'costo' => $resultado['costo'],
                'tarifa' => $resultado['tarifa']
            ];
            
            log_message('info', "Enviando respuesta: " . json_encode($response));
            return $this->response->setJSON($response);
            
        } catch (Exception $e) {
            log_message('error', "Error en calcularCosto: " . $e->getMessage());
            log_message('error', "Stack trace: " . $e->getTraceAsString());
            return $this->response->setJSON(['success' => false, 'message' => 'Error interno del servidor']);
        }
    }
}
