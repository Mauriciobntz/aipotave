<?php
namespace App\Controllers;

use App\Models\ComboModel;
use App\Models\ProductoModel;
use CodeIgniter\Controller;

/**
 * Controlador para la gestión de combos en el panel admin.
 */
class ComboController extends Controller
{
    /**
     * Muestra el listado de combos.
     */
    public function listar()
    {
        $comboModel = new ComboModel();
        $combos = $comboModel->orderBy('nombre', 'asc')->findAll();
        $data = [
            'title' => 'Listado de Combos',
            'combos' => $combos
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/combos_listar')
            . view('footer');
    }

    /**
     * Muestra el formulario para agregar un combo.
     */
    public function agregarCombo()
    {
        $productoModel = new ProductoModel();
        $productos = $productoModel->where('activo', 1)->orderBy('nombre', 'asc')->findAll();
        $data = [
            'title' => 'Agregar Combo',
            'combo' => null,
            'productos' => $productos,
            'productos_en_combo' => []
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/combo_form')
            . view('footer');
    }

    /**
     * Procesa el alta de un combo.
     */
    public function guardarCombo()
    {
        $comboModel = new ComboModel();
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
            'activo' => 1,
            'imagen' => $this->request->getPost('imagen')
        ];
        $comboId = $comboModel->insert($data, true);
        // Guardar productos en combo
        $productos = $this->request->getPost('productos'); // array de producto_id => cantidad
        if ($productos && is_array($productos)) {
            $db = \Config\Database::connect();
            foreach ($productos as $producto_id => $cantidad) {
                if ($cantidad > 0) {
                    $db->table('productos_en_combos')->insert([
                        'combo_id' => $comboId,
                        'producto_id' => $producto_id,
                        'cantidad' => $cantidad
                    ]);
                }
            }
        }
        return redirect()->to(base_url('admin/combos/listar'))->with('success', 'Combo agregado correctamente.');
    }

    /**
     * Muestra el formulario para editar un combo.
     * @param int $id
     */
    public function editarCombo($id)
    {
        $comboModel = new ComboModel();
        $productoModel = new ProductoModel();
        $combo = $comboModel->find($id);
        if (!$combo) {
            return redirect()->to(base_url('admin/combos/listar'))->with('error', 'Combo no encontrado.');
        }
        $productos = $productoModel->where('activo', 1)->orderBy('nombre', 'asc')->findAll();
        // Obtener productos en combo
        $db = \Config\Database::connect();
        $productos_en_combo = [];
        $rows = $db->table('productos_en_combos')->where('combo_id', $id)->get()->getResultArray();
        foreach ($rows as $row) {
            $productos_en_combo[$row['producto_id']] = $row['cantidad'];
        }
        $data = [
            'title' => 'Editar Combo',
            'combo' => $combo,
            'productos' => $productos,
            'productos_en_combo' => $productos_en_combo
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/combo_form')
            . view('footer');
    }

    /**
     * Procesa la edición de un combo.
     * @param int $id
     */
    public function actualizarCombo($id)
    {
        $comboModel = new ComboModel();
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
        $comboModel->update($id, $data);
        // Actualizar productos en combo
        $db = \Config\Database::connect();
        $db->table('productos_en_combos')->where('combo_id', $id)->delete();
        $productos = $this->request->getPost('productos'); // array de producto_id => cantidad
        if ($productos && is_array($productos)) {
            foreach ($productos as $producto_id => $cantidad) {
                if ($cantidad > 0) {
                    $db->table('productos_en_combos')->insert([
                        'combo_id' => $id,
                        'producto_id' => $producto_id,
                        'cantidad' => $cantidad
                    ]);
                }
            }
        }
        return redirect()->to(base_url('admin/combos/listar'))->with('success', 'Combo actualizado correctamente.');
    }

    /**
     * Elimina un combo de la base de datos.
     * @param int $id
     */
    public function eliminar($id)
    {
        $comboModel = new ComboModel();
        $comboModel->delete($id);
        $db = \Config\Database::connect();
        $db->table('productos_en_combos')->where('combo_id', $id)->delete();
        return redirect()->to(base_url('admin/combos/listar'))->with('success', 'Combo eliminado.');
    }
} 