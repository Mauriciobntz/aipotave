<?php
namespace App\Controllers;

use App\Models\RepartidorModel;
use CodeIgniter\Controller;

/**
 * Controlador para la administración de repartidores.
 */
class RepartidorAdminController extends Controller
{
    /**
     * Muestra el listado de repartidores.
     */
    public function listar()
    {
        $model = new RepartidorModel();
        $repartidores = $model->orderBy('nombre', 'asc')->findAll();
        $data = [
            'title' => 'Listado de Repartidores',
            'repartidores' => $repartidores
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/repartidores_listar')
            . view('footer_admin');
    }

    /**
     * Muestra el formulario para agregar un repartidor.
     */
    public function agregar()
    {
        $data = [
            'title' => 'Agregar Repartidor',
            'repartidor' => null
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/repartidor_form')
            . view('footer_admin');
    }

    /**
     * Procesa el alta de un repartidor.
     */
    public function guardar()
    {
        $model = new RepartidorModel();
        $rules = [
            'nombre' => 'required|min_length[3]',
            'telefono' => 'required',
            'email' => 'permit_empty|valid_email',
            'vehiculo' => 'permit_empty',
            'password' => 'required|min_length[4]'
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Completa los campos obligatorios.');
        }
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'telefono' => $this->request->getPost('telefono'),
            'email' => $this->request->getPost('email'),
            'vehiculo' => $this->request->getPost('vehiculo'),
            'password' => $this->request->getPost('password'),
            'activo' => 1,
            'disponible' => 1
        ];
        $model->insert($data);
        return redirect()->to(base_url('admin/repartidores/listar'))->with('success', 'Repartidor agregado correctamente.');
    }

    /**
     * Muestra el formulario para editar un repartidor.
     * @param int $id
     */
    public function editar($id)
    {
        $model = new RepartidorModel();
        $repartidor = $model->find($id);
        if (!$repartidor) {
            return redirect()->to(base_url('admin/repartidores/listar'))->with('error', 'Repartidor no encontrado.');
        }
        $data = [
            'title' => 'Editar Repartidor',
            'repartidor' => $repartidor
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/repartidor_form')
            . view('footer_admin');
    }

    /**
     * Procesa la edición de un repartidor.
     * @param int $id
     */
    public function actualizar($id)
    {
        $model = new RepartidorModel();
        $rules = [
            'nombre' => 'required|min_length[3]',
            'telefono' => 'required',
            'email' => 'permit_empty|valid_email',
            'vehiculo' => 'permit_empty'
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Completa los campos obligatorios.');
        }
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'telefono' => $this->request->getPost('telefono'),
            'email' => $this->request->getPost('email'),
            'vehiculo' => $this->request->getPost('vehiculo')
        ];
        $password = $this->request->getPost('password');
        if ($password) {
            $data['password'] = $password;
        }
        $model->update($id, $data);
        return redirect()->to(base_url('admin/repartidores/listar'))->with('success', 'Repartidor actualizado correctamente.');
    }

    /**
     * Elimina un repartidor de la base de datos.
     * @param int $id
     */
    public function eliminar($id)
    {
        $model = new RepartidorModel();
        $model->delete($id);
        return redirect()->to(base_url('admin/repartidores/listar'))->with('success', 'Repartidor eliminado.');
    }
} 