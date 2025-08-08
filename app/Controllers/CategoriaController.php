<?php
namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\SubcategoriaModel;
use CodeIgniter\Controller;

/**
 * Controlador para la gestión de categorías.
 */
class CategoriaController extends Controller
{
    protected $categoriaModel;
    protected $subcategoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
        $this->subcategoriaModel = new SubcategoriaModel();
    }

    /**
     * Muestra el listado de categorías.
     */
    public function listar()
    {
        $categorias = $this->categoriaModel->getCategoriasConSubcategorias();
        
        $data = [
            'title' => 'Gestión de Categorías',
            'categorias' => $categorias
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/categorias/listar', $data)
            . view('footer_admin');
    }

    /**
     * Muestra el formulario para agregar una categoría.
     */
    public function agregar()
    {
        $data = [
            'title' => 'Agregar Categoría',
            'categoria' => null
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/categorias/form', $data)
            . view('footer_admin');
    }

    /**
     * Guarda una nueva categoría.
     */
    public function guardar()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre' => 'required|min_length[3]|max_length[100]',
            'descripcion' => 'max_length[500]',
            'orden' => 'integer|greater_than_equal_to[0]',
            'activo' => 'in_list[0,1]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $categoriaModel = new CategoriaModel();
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'orden' => (int)$this->request->getPost('orden') ?: 0,
            'activo' => $this->request->getPost('activo') ? 1 : 0
        ];

        if ($categoriaModel->insert($data)) {
            return redirect()->to('admin/categorias')->with('success', 'Categoría creada exitosamente');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al crear la categoría');
        }
    }

    /**
     * Muestra el formulario para editar una categoría.
     * @param int $id
     */
    public function editar($id)
    {
        $categoria = $this->categoriaModel->find($id);
        if (!$categoria) {
            return redirect()->to(base_url('admin/categorias'))->with('error', 'Categoría no encontrada.');
        }
        
        $data = [
            'title' => 'Editar Categoría',
            'categoria' => $categoria
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/categorias/form', $data)
            . view('footer_admin');
    }

    /**
     * Actualiza una categoría existente.
     * @param int $id
     */
    public function actualizar($id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre' => 'required|min_length[3]|max_length[100]',
            'descripcion' => 'max_length[500]',
            'orden' => 'integer|greater_than_equal_to[0]',
            'activo' => 'in_list[0,1]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $categoriaModel = new CategoriaModel();
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'orden' => (int)$this->request->getPost('orden') ?: 0,
            'activo' => $this->request->getPost('activo') ? 1 : 0
        ];

        if ($categoriaModel->update($id, $data)) {
            return redirect()->to('admin/categorias')->with('success', 'Categoría actualizada exitosamente');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar la categoría');
        }
    }

    /**
     * Elimina una categoría (desactiva).
     * @param int $id
     */
    public function eliminar($id)
    {
        // Verificar si tiene subcategorías activas
        $subcategorias = $this->subcategoriaModel->where('categoria_id', $id)
                                                ->where('activo', 1)
                                                ->findAll();
        
        if (!empty($subcategorias)) {
            return redirect()->back()->with('error', 'No se puede eliminar la categoría porque tiene subcategorías activas.');
        }
        
        if ($this->categoriaModel->update($id, ['activo' => 0])) {
            return redirect()->back()->with('success', 'Categoría eliminada correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al eliminar la categoría.');
        }
    }
} 