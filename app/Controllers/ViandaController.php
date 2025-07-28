<?php
namespace App\Controllers;

use App\Models\ViandaModel;
use CodeIgniter\Controller;

/**
 * Controlador para la gestión de viandas diarias y su stock.
 */
class ViandaController extends Controller
{
    /**
     * Muestra el listado de viandas.
     */
    public function listar()
    {
        $viandaModel = new ViandaModel();
        $viandas = $viandaModel->listarViandas();
        $data = [
            'title' => 'Listado de Viandas',
            'viandas' => $viandas
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/viandas_listar')
            . view('footer');
    }

    /**
     * Muestra el formulario para agregar una vianda.
     */
    public function agregarVianda()
    {
        $data = [
            'title' => 'Agregar Vianda',
            'vianda' => null
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/vianda_form')
            . view('footer');
    }

    /**
     * Procesa el alta de una vianda.
     */
    public function guardarVianda()
    {
        $viandaModel = new ViandaModel();
        $rules = [
            'nombre' => 'required|min_length[3]',
            'precio' => 'required|decimal'
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Completa los campos obligatorios.');
        }
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio' => $this->request->getPost('precio'),
            'tipo' => 'vianda',
            'activo' => 1,
            'imagen' => $this->request->getPost('imagen')
        ];
        $viandaModel->insert($data);
        return redirect()->to(base_url('admin/viandas/listar'))->with('success', 'Vianda agregada correctamente.');
    }

    /**
     * Muestra el formulario para editar una vianda.
     * @param int $id
     */
    public function editarVianda($id)
    {
        $viandaModel = new ViandaModel();
        $vianda = $viandaModel->getById($id);
        if (!$vianda) {
            return redirect()->to(base_url('admin/viandas/listar'))->with('error', 'Vianda no encontrada.');
        }
        $data = [
            'title' => 'Editar Vianda',
            'vianda' => $vianda
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/vianda_form')
            . view('footer');
    }

    /**
     * Procesa la edición de una vianda.
     * @param int $id
     */
    public function actualizarVianda($id)
    {
        $viandaModel = new ViandaModel();
        $rules = [
            'nombre' => 'required|min_length[3]',
            'precio' => 'required|decimal'
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Completa los campos obligatorios.');
        }
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio' => $this->request->getPost('precio'),
            'imagen' => $this->request->getPost('imagen')
        ];
        $viandaModel->update($id, $data);
        return redirect()->to(base_url('admin/viandas/listar'))->with('success', 'Vianda actualizada correctamente.');
    }

    /**
     * Elimina una vianda de la base de datos.
     * @param int $id
     */
    public function eliminar($id)
    {
        $viandaModel = new ViandaModel();
        $viandaModel->delete($id);
        return redirect()->to(base_url('admin/viandas/listar'))->with('success', 'Vianda eliminada.');
    }

    /**
     * Muestra y actualiza el stock de una vianda por fecha.
     * @param int $id
     */
    public function stock($id)
    {
        $viandaModel = new ViandaModel();
        $vianda = $viandaModel->getById($id);
        if (!$vianda) {
            return redirect()->to(base_url('admin/viandas/listar'))->with('error', 'Vianda no encontrada.');
        }
        $fecha = $this->request->getGet('fecha') ?: date('Y-m-d');
        if ($this->request->getMethod() === 'post') {
            $nuevaCantidad = (int)$this->request->getPost('cantidad');
            $viandaModel->setStock($id, $fecha, $nuevaCantidad);
            return redirect()->to(base_url('admin/viandas/stock/' . $id . '?fecha=' . $fecha))->with('success', 'Stock actualizado.');
        }
        $stock = $viandaModel->getStock($id, $fecha);
        $data = [
            'title' => 'Stock de Vianda',
            'vianda' => $vianda,
            'fecha' => $fecha,
            'stock' => $stock
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/vianda_stock')
            . view('footer');
    }
} 