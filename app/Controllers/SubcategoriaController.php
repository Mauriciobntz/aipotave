<?php
namespace App\Controllers;

use App\Models\SubcategoriaModel;
use App\Models\CategoriaModel;
use CodeIgniter\Controller;

/**
 * Controlador para la gestión de subcategorías.
 */
class SubcategoriaController extends Controller
{
    protected $subcategoriaModel;
    protected $categoriaModel;

    public function __construct()
    {
        $this->subcategoriaModel = new SubcategoriaModel();
        $this->categoriaModel = new CategoriaModel();
    }

    /**
     * Muestra el listado de subcategorías.
     */
    public function listar()
    {
        $subcategorias = $this->subcategoriaModel->getSubcategoriasConCategoria();
        
        $data = [
            'title' => 'Gestión de Subcategorías',
            'subcategorias' => $subcategorias
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/subcategorias/listar', $data)
            . view('footer_admin');
    }

    /**
     * Muestra el formulario para agregar una subcategoría.
     */
    public function agregar()
    {
        $categorias = $this->categoriaModel->getAllActivas();
        
        $data = [
            'title' => 'Agregar Subcategoría',
            'subcategoria' => null,
            'categorias' => $categorias
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/subcategorias/form', $data)
            . view('footer_admin');
    }

    /**
     * Guarda una nueva subcategoría.
     */
    public function guardar()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre' => 'required|min_length[3]|max_length[100]',
            'categoria_id' => 'required|integer|is_not_unique[categorias.id]',
            'descripcion' => 'max_length[500]',
            'activo' => 'in_list[0,1]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $subcategoriaModel = new SubcategoriaModel();
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'categoria_id' => $this->request->getPost('categoria_id'),
            'descripcion' => $this->request->getPost('descripcion'),
            'activo' => $this->request->getPost('activo') ? 1 : 0
        ];

        if ($subcategoriaModel->insert($data)) {
            return redirect()->to('admin/subcategorias')->with('success', 'Subcategoría creada exitosamente');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al crear la subcategoría');
        }
    }

    /**
     * Muestra el formulario para editar una subcategoría.
     * @param int $id
     */
    public function editar($id)
    {
        $subcategoria = $this->subcategoriaModel->find($id);
        if (!$subcategoria) {
            return redirect()->to(base_url('admin/subcategorias'))->with('error', 'Subcategoría no encontrada.');
        }
        
        $categorias = $this->categoriaModel->getAllActivas();
        
        $data = [
            'title' => 'Editar Subcategoría',
            'subcategoria' => $subcategoria,
            'categorias' => $categorias
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/subcategorias/form', $data)
            . view('footer_admin');
    }

    /**
     * Actualiza una subcategoría existente.
     * @param int $id
     */
    public function actualizar($id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre' => 'required|min_length[3]|max_length[100]',
            'categoria_id' => 'required|integer|is_not_unique[categorias.id]',
            'descripcion' => 'max_length[500]',
            'activo' => 'in_list[0,1]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $subcategoriaModel = new SubcategoriaModel();
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'categoria_id' => $this->request->getPost('categoria_id'),
            'descripcion' => $this->request->getPost('descripcion'),
            'activo' => $this->request->getPost('activo') ? 1 : 0
        ];

        if ($subcategoriaModel->update($id, $data)) {
            return redirect()->to('admin/subcategorias')->with('success', 'Subcategoría actualizada exitosamente');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar la subcategoría');
        }
    }

    /**
     * Elimina una subcategoría (desactiva).
     * @param int $id
     */
    public function eliminar($id)
    {
        // Verificar si tiene productos activos
        $productoModel = new \App\Models\ProductoModel();
        $productos = $productoModel->where('subcategoria_id', $id)
                                  ->where('activo', 1)
                                  ->findAll();
        
        if (!empty($productos)) {
            return redirect()->back()->with('error', 'No se puede eliminar la subcategoría porque tiene productos activos.');
        }
        
        if ($this->subcategoriaModel->update($id, ['activo' => 0])) {
            return redirect()->back()->with('success', 'Subcategoría eliminada correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al eliminar la subcategoría.');
        }
    }
} 