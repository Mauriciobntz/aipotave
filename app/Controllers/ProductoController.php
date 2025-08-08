<?php
namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use App\Models\SubcategoriaModel;
use CodeIgniter\Controller;

/**
 * Controlador para la gestión de productos en el panel admin.
 */
class ProductoController extends Controller
{
    protected $productoModel;
    protected $categoriaModel;
    protected $subcategoriaModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
        $this->subcategoriaModel = new SubcategoriaModel();
    }

    /**
     * Muestra el listado de productos.
     */
    public function listar()
    {
        // Obtener filtros de la URL
        $tipo_filtro = $this->request->getGet('tipo') ?? '';
        $categoria_filtro = $this->request->getGet('categoria_id') ?? '';
        $subcategoria_filtro = $this->request->getGet('subcategoria_id') ?? '';
        $estado_filtro = $this->request->getGet('estado') ?? '';
        $activo_filtro = $this->request->getGet('activo') ?? '';
        $busqueda = $this->request->getGet('busqueda') ?? '';
        
        $productos = $this->productoModel->getProductosConSubcategoria();
        $categorias = $this->categoriaModel->getAllActivas();
        $subcategorias = $this->subcategoriaModel->getAllActivas();
        
        // Aplicar filtros
        if (!empty($tipo_filtro)) {
            $productos = array_filter($productos, function($producto) use ($tipo_filtro) {
                return $producto['tipo'] == $tipo_filtro;
            });
        }
        
        if (!empty($categoria_filtro)) {
            $productos = array_filter($productos, function($producto) use ($categoria_filtro) {
                return $producto['categoria_id'] == $categoria_filtro;
            });
        }
        
        if (!empty($subcategoria_filtro)) {
            $productos = array_filter($productos, function($producto) use ($subcategoria_filtro) {
                return $producto['subcategoria_id'] == $subcategoria_filtro;
            });
        }
        
        if (!empty($estado_filtro)) {
            $productos = array_filter($productos, function($producto) use ($estado_filtro) {
                return $producto['activo'] == ($estado_filtro == 'activo' ? 1 : 0);
            });
        }
        
        if (!empty($activo_filtro)) {
            $productos = array_filter($productos, function($producto) use ($activo_filtro) {
                // Convertir el valor de activo_filtro a entero para comparar correctamente
                $filtro_valor = (int)$activo_filtro;
                return $producto['activo'] == $filtro_valor;
            });
        }
        
        if (!empty($busqueda)) {
            $productos = array_filter($productos, function($producto) use ($busqueda) {
                return stripos($producto['nombre'], $busqueda) !== false ||
                       stripos($producto['descripcion'], $busqueda) !== false;
            });
        }
        
        $data = [
            'title' => 'Listado de Productos',
            'productos' => $productos,
            'categorias' => $categorias,
            'subcategorias' => $subcategorias,
            'tipo_filtro' => $tipo_filtro,
            'categoria_filtro' => $categoria_filtro,
            'subcategoria_filtro' => $subcategoria_filtro,
            'estado_filtro' => $estado_filtro,
            'activo_filtro' => $activo_filtro,
            'busqueda' => $busqueda
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/productos_listar', $data)
            . view('footer_admin');
    }

    /**
     * Muestra el formulario para agregar un producto.
     */
    public function agregarProducto()
    {
        $categorias = $this->categoriaModel->getAllActivas();
        $subcategorias = $this->subcategoriaModel->getAllActivas();
        
        $data = [
            'title' => 'Agregar Producto',
            'producto' => null,
            'categorias' => $categorias,
            'subcategorias' => $subcategorias
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/producto_form', $data)
            . view('footer_admin');
    }

    /**
     * Procesa el alta de un producto.
     */
    public function guardarProducto()
    {
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules([
            'nombre' => 'required|min_length[3]|max_length[100]',
            'descripcion' => 'max_length[500]',
            'precio' => 'required|decimal|greater_than[0]',
            'tipo' => 'required|in_list[comida,bebida,vianda]',
            'categoria_id' => 'permit_empty|integer',
            'subcategoria_id' => 'permit_empty|integer',
            'imagen' => 'permit_empty|uploaded[imagen]|max_size[imagen,2048]|is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png,image/webp]'
        ], [
            'nombre' => [
                'required' => 'El nombre es obligatorio',
                'min_length' => 'El nombre debe tener al menos 3 caracteres',
                'max_length' => 'El nombre no puede exceder los 100 caracteres'
            ],
            'descripcion' => [
                'max_length' => 'La descripción no puede exceder los 500 caracteres'
            ],
            'precio' => [
                'required' => 'El precio es obligatorio',
                'decimal' => 'El precio debe ser un número válido',
                'greater_than' => 'El precio debe ser mayor a 0'
            ],
            'tipo' => [
                'required' => 'El tipo es obligatorio',
                'in_list' => 'El tipo debe ser comida, bebida o vianda'
            ],
            'categoria_id' => [
                'integer' => 'La categoría debe ser un número válido'
            ],
            'subcategoria_id' => [
                'integer' => 'La subcategoría debe ser un número válido'
            ],
            'imagen' => [
                'max_size' => 'La imagen no puede exceder los 2MB',
                'is_image' => 'El archivo debe ser una imagen válida',
                'mime_in' => 'Formatos permitidos: JPG, JPEG, PNG, WEBP'
            ]
        ]);

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $imagen = $this->request->getFile('imagen');
        $nombreImagen = '';
        if ($imagen->isValid() && !$imagen->hasMoved()) {
            $nombreImagen = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/productos/', $nombreImagen);
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio' => $this->request->getPost('precio'),
            'tipo' => $this->request->getPost('tipo'),
            'categoria_id' => $this->request->getPost('categoria_id') ?: null,
            'subcategoria_id' => $this->request->getPost('subcategoria_id') ?: null,
            'imagen' => $nombreImagen ? 'uploads/productos/' . $nombreImagen : '',
            'activo' => $this->request->getPost('activo') ? 1 : 0,
            'fecha_creacion' => date('Y-m-d H:i:s')
        ];

        if ($this->productoModel->insert($data)) {
            return redirect()->to(base_url('admin/productos/listar'))->with('success', 'Producto agregado correctamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al agregar el producto.');
        }
    }

    /**
     * Muestra el formulario para editar un producto.
     * @param int $id
     */
    public function editarProducto($id)
    {
        $producto = $this->productoModel->find($id);
        if (!$producto) {
            return redirect()->to(base_url('admin/productos/listar'))->with('error', 'Producto no encontrado.');
        }
        
        $categorias = $this->categoriaModel->getAllActivas();
        $subcategorias = $this->subcategoriaModel->getAllActivas();
        
        $data = [
            'title' => 'Editar Producto',
            'producto' => $producto,
            'categorias' => $categorias,
            'subcategorias' => $subcategorias
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/producto_form', $data)
            . view('footer_admin');
    }

    /**
     * Procesa la edición de un producto.
     * @param int $id
     */
    public function actualizarProducto($id)
    {
        $producto = $this->productoModel->find($id);
        if (!$producto) {
            return redirect()->to(base_url('admin/productos/listar'))->with('error', 'Producto no encontrado.');
        }

        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $validation->setRules([
            'nombre' => 'required|min_length[3]|max_length[100]',
            'descripcion' => 'max_length[500]',
            'precio' => 'required|decimal|greater_than[0]',
            'tipo' => 'required|in_list[comida,bebida,vianda]',
            'categoria_id' => 'permit_empty|integer',
            'subcategoria_id' => 'permit_empty|integer'
        ], [
            'nombre' => [
                'required' => 'El nombre es obligatorio',
                'min_length' => 'El nombre debe tener al menos 3 caracteres',
                'max_length' => 'El nombre no puede exceder los 100 caracteres'
            ],
            'descripcion' => [
                'max_length' => 'La descripción no puede exceder los 500 caracteres'
            ],
            'precio' => [
                'required' => 'El precio es obligatorio',
                'decimal' => 'El precio debe ser un número válido',
                'greater_than' => 'El precio debe ser mayor a 0'
            ],
            'tipo' => [
                'required' => 'El tipo es obligatorio',
                'in_list' => 'El tipo debe ser comida, bebida o vianda'
            ],
            'categoria_id' => [
                'integer' => 'La categoría debe ser un número válido'
            ],
            'subcategoria_id' => [
                'integer' => 'La subcategoría debe ser un número válido'
            ]
        ]);

        $imagen = $this->request->getFile('imagen');
        if ($imagen && $imagen->isValid()) {
            $validation->setRules([
                'imagen' => 'max_size[imagen,2048]|is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png,image/webp]'
            ], [
                'imagen' => [
                    'max_size' => 'La imagen no puede exceder los 2MB',
                    'is_image' => 'El archivo debe ser una imagen válida',
                    'mime_in' => 'Formatos permitidos: JPG, JPEG, PNG, WEBP'
                ]
            ]);
        }

        if (!$validation->withRequest($request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio' => $this->request->getPost('precio'),
            'tipo' => $this->request->getPost('tipo'),
            'categoria_id' => $this->request->getPost('categoria_id') ?: null,
            'subcategoria_id' => $this->request->getPost('subcategoria_id') ?: null,
            'activo' => $this->request->getPost('activo') ? 1 : 0
        ];

        if ($imagen && $imagen->isValid()) {
            // Eliminar imagen anterior si existe
            if ($producto['imagen'] && file_exists(ROOTPATH . 'public/' . $producto['imagen'])) {
                unlink(ROOTPATH . 'public/' . $producto['imagen']);
            }

            $nombreImagen = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/productos/', $nombreImagen);
            $data['imagen'] = 'uploads/productos/' . $nombreImagen;
        }

        if ($this->productoModel->update($id, $data)) {
            return redirect()->to(base_url('admin/productos/listar'))->with('success', 'Producto actualizado correctamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el producto.');
        }
    }

    /**
     * Desactiva un producto (no lo elimina de la base de datos).
     * @param int $id
     */
    public function desactivar($id)
    {
        if ($this->productoModel->update($id, ['activo' => 0])) {
            return redirect()->to(base_url('admin/productos/listar'))->with('success', 'Producto desactivado.');
        } else {
            return redirect()->to(base_url('admin/productos/listar'))->with('error', 'Error al desactivar el producto.');
        }
    }

    /**
     * Activa un producto previamente desactivado.
     * @param int $id
     */
    public function activar($id)
    {
        if ($this->productoModel->update($id, ['activo' => 1])) {
            return redirect()->to(base_url('admin/productos/listar'))->with('success', 'Producto activado.');
        } else {
            return redirect()->to(base_url('admin/productos/listar'))->with('error', 'Error al activar el producto.');
        }
    }

    /**
     * Elimina un producto de la base de datos.
     * @param int $id
     */
    public function eliminar($id)
    {
        // Obtener el producto antes de eliminarlo
        $producto = $this->productoModel->find($id);
        if (!$producto) {
            return redirect()->to(base_url('admin/productos/listar'))->with('error', 'Producto no encontrado.');
        }

        // Verificar si el producto tiene pedidos asociados
        $detalleModel = new \App\Models\DetallePedidoModel();
        $detalles = $detalleModel->where('producto_id', $id)->findAll();
        
        if (!empty($detalles)) {
            return redirect()->to(base_url('admin/productos/listar'))->with('error', 'No se puede eliminar el producto porque tiene pedidos asociados.');
        }
        
        // Eliminar la imagen del servidor si existe
        if (!empty($producto['imagen']) && file_exists(ROOTPATH . 'public/' . $producto['imagen'])) {
            unlink(ROOTPATH . 'public/' . $producto['imagen']);
        }
        
        if ($this->productoModel->delete($id)) {
            return redirect()->to(base_url('admin/productos/listar'))->with('success', 'Producto eliminado.');
        } else {
            return redirect()->to(base_url('admin/productos/listar'))->with('error', 'Error al eliminar el producto.');
        }
    }

    /**
     * Obtiene subcategorías por categoría (AJAX)
     */
    public function getSubcategorias($categoria_id)
    {
        $subcategorias = $this->subcategoriaModel->getByCategoria($categoria_id);
        return $this->response->setJSON($subcategorias);
    }

    /**
     * Muestra productos por tipo
     */
    public function porTipo($tipo)
    {
        $productos = $this->productoModel->getByTipo($tipo);
        $data = [
            'title' => 'Productos - ' . ucfirst($tipo),
            'productos' => $productos,
            'tipo' => $tipo
        ];
        return view('header', $data)
            . view('navbar')
            . view('admin/productos_listar', $data)
            . view('footer_admin');
    }


} 