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
            . view('footer_admin');
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
            . view('footer_admin');
    }

    /**
     * Procesa el alta de un combo.
     */
    public function guardarCombo()
    {
        $comboModel = new ComboModel();
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'nombre' => 'required|min_length[3]|max_length[100]',
            'descripcion' => 'max_length[500]',
            'precio' => 'required|decimal|greater_than[0]',
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
            'imagen' => [
                'max_size' => 'La imagen no puede exceder los 2MB',
                'is_image' => 'El archivo debe ser una imagen válida',
                'mime_in' => 'Formatos permitidos: JPG, JPEG, PNG, WEBP'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $imagen = $this->request->getFile('imagen');
        $nombreImagen = '';
        if ($imagen->isValid() && !$imagen->hasMoved()) {
            $nombreImagen = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/combos/', $nombreImagen);
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio' => $this->request->getPost('precio'),
            'imagen' => $nombreImagen ? 'uploads/combos/' . $nombreImagen : '',
            'activo' => 1,
            'fecha_creacion' => date('Y-m-d H:i:s')
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
            . view('footer_admin');
    }

    /**
     * Procesa la edición de un combo.
     * @param int $id
     */
    public function actualizarCombo($id)
    {
        $comboModel = new ComboModel();
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'nombre' => 'required|min_length[3]|max_length[100]',
            'descripcion' => 'max_length[500]',
            'precio' => 'required|decimal|greater_than[0]'
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
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $combo = $comboModel->find($id);
        if (!$combo) {
            return redirect()->back()->withInput()->with('error', 'Combo no encontrado.');
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio' => $this->request->getPost('precio')
        ];

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

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            // Eliminar imagen anterior si existe
            if ($combo['imagen'] && file_exists(ROOTPATH . 'public/' . $combo['imagen'])) {
                unlink(ROOTPATH . 'public/' . $combo['imagen']);
            }

            $nombreImagen = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/combos/', $nombreImagen);
            $data['imagen'] = 'uploads/combos/' . $nombreImagen;
        }
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