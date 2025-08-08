<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SlideModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class SlidesController extends BaseController
{
    protected $slideModel;

    public function __construct()
    {
        $this->slideModel = new SlideModel();
    }

    /**
     * Lista todos los slides
     */
    public function index()
    {
        $slides = $this->slideModel->orderBy('orden', 'ASC')->findAll();

        $data = [
            'title' => 'Gestión de Slides',
            'slides' => $slides
        ];

        return view('header', $data)
            . view('navbar_admin')
            . view('admin/slides/index')
            . view('footer_admin');
    }

    /**
     * Muestra el formulario para crear un nuevo slide
     */
    public function crear()
    {
        $data = [
            'title' => 'Crear Nuevo Slide',
            'slide' => null
        ];

        return view('header', $data)
            . view('navbar_admin')
            . view('admin/slides/form')
            . view('footer_admin');
    }

    /**
     * Guarda un nuevo slide
     */
    public function guardar()
    {
        // Validar datos
        $rules = [
            'titulo' => 'required|max_length[100]',
            'subtitulo' => 'max_length[255]',
            'imagen' => 'uploaded[imagen]|max_size[imagen,2048]|is_image[imagen]',
            'link_destino' => 'max_length[255]',
            'orden' => 'integer|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Procesar imagen
        $imagen = $this->request->getFile('imagen');
        $nombreImagen = null;

        if ($imagen->isValid() && !$imagen->hasMoved()) {
            $nombreImagen = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/slides/', $nombreImagen);
            $nombreImagen = 'uploads/slides/' . $nombreImagen;
        }

        // Preparar datos
        $datos = [
            'titulo' => $this->request->getPost('titulo'),
            'subtitulo' => $this->request->getPost('subtitulo'),
            'imagen' => $nombreImagen,
            'link_destino' => $this->request->getPost('link_destino'),
            'activo' => $this->request->getPost('activo') ? 1 : 0,
            'orden' => $this->request->getPost('orden') ?: $this->slideModel->getSiguienteOrden(),
            'fecha_creacion' => date('Y-m-d H:i:s')
        ];

        // Guardar slide
        if ($this->slideModel->insert($datos)) {
            return redirect()->to('admin/slides')->with('success', 'Slide creado exitosamente');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al crear el slide');
        }
    }

    /**
     * Muestra el formulario para editar un slide
     */
    public function editar($id)
    {
        $slide = $this->slideModel->find($id);

        if (!$slide) {
            return redirect()->to('admin/slides')->with('error', 'Slide no encontrado');
        }

        $data = [
            'title' => 'Editar Slide',
            'slide' => $slide
        ];

        return view('header', $data)
            . view('navbar_admin')
            . view('admin/slides/form')
            . view('footer_admin');
    }

    /**
     * Actualiza un slide existente
     */
    public function actualizar($id)
    {
        $slide = $this->slideModel->find($id);

        if (!$slide) {
            return redirect()->to('admin/slides')->with('error', 'Slide no encontrado');
        }

        // Validar datos
        $rules = [
            'titulo' => 'required|max_length[100]',
            'subtitulo' => 'max_length[255]',
            'imagen' => 'is_image[imagen]|max_size[imagen,2048]',
            'link_destino' => 'max_length[255]',
            'orden' => 'integer|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Procesar imagen si se subió una nueva
        $imagen = $this->request->getFile('imagen');
        $nombreImagen = $slide['imagen']; // Mantener imagen actual por defecto

        if ($imagen->isValid() && !$imagen->hasMoved()) {
            // Eliminar imagen anterior si existe
            if ($slide['imagen'] && file_exists(ROOTPATH . 'public/' . $slide['imagen'])) {
                unlink(ROOTPATH . 'public/' . $slide['imagen']);
            }

            $nombreImagen = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/slides/', $nombreImagen);
            $nombreImagen = 'uploads/slides/' . $nombreImagen;
        }

        // Preparar datos
        $datos = [
            'titulo' => $this->request->getPost('titulo'),
            'subtitulo' => $this->request->getPost('subtitulo'),
            'imagen' => $nombreImagen,
            'link_destino' => $this->request->getPost('link_destino'),
            'activo' => $this->request->getPost('activo') ? 1 : 0,
            'orden' => $this->request->getPost('orden')
        ];

        // Actualizar slide
        if ($this->slideModel->update($id, $datos)) {
            return redirect()->to('admin/slides')->with('success', 'Slide actualizado exitosamente');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el slide');
        }
    }

    /**
     * Elimina un slide (cambia estado a inactivo)
     */
    public function eliminar($id)
    {
        $slide = $this->slideModel->find($id);

        if (!$slide) {
            return redirect()->to('admin/slides')->with('error', 'Slide no encontrado');
        }

        if ($this->slideModel->eliminarSlide($id)) {
            return redirect()->to('admin/slides')->with('success', 'Slide eliminado exitosamente');
        } else {
            return redirect()->to('admin/slides')->with('error', 'Error al eliminar el slide');
        }
    }

    /**
     * Cambia el estado activo/inactivo de un slide
     */
    public function toggleEstado($id)
    {
        $slide = $this->slideModel->find($id);

        if (!$slide) {
            return redirect()->to('admin/slides')->with('error', 'Slide no encontrado');
        }

        $nuevoEstado = $slide['activo'] ? 0 : 1;
        
        if ($this->slideModel->update($id, ['activo' => $nuevoEstado])) {
            $mensaje = $nuevoEstado ? 'Slide activado' : 'Slide desactivado';
            return redirect()->to('admin/slides')->with('success', $mensaje . ' exitosamente');
        } else {
            return redirect()->to('admin/slides')->with('error', 'Error al cambiar el estado del slide');
        }
    }

    /**
     * Reordena los slides
     */
    public function reordenar()
    {
        $ordenes = $this->request->getPost('ordenes');

        if (!$ordenes || !is_array($ordenes)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Datos inválidos']);
        }

        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($ordenes as $id => $orden) {
            $this->slideModel->update($id, ['orden' => $orden]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al reordenar']);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Orden actualizado']);
    }
} 