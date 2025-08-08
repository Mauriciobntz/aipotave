<?php

namespace App\Controllers;

use App\Models\ConfiguracionModel;

class ConfiguracionController extends BaseController
{
    protected $configuracionModel;

    public function __construct()
    {
        $this->configuracionModel = new ConfiguracionModel();
    }

    /**
     * Muestra la lista de configuraciones
     */
    public function index()
    {
        // Verificar permisos de administrador
        if (!session('logueado') || session('user_role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Acceso denegado');
        }

        $page = $this->request->getGet('page') ?? 1;
        $perPage = 20;
        
        // Filtros
        $filtros = [
            'seccion' => $this->request->getGet('seccion'),
            'tipo' => $this->request->getGet('tipo'),
            'activo' => $this->request->getGet('activo'),
            'buscar' => $this->request->getGet('buscar')
        ];

        $resultado = $this->configuracionModel->getConPaginacion($page, $perPage, $filtros);

        $data = [
            'title' => 'Configuración del Sitio',
            'configuraciones' => $resultado['data'],
            'pagination' => [
                'current' => $resultado['page'],
                'total' => $resultado['totalPages'],
                'perPage' => $resultado['perPage'],
                'totalRecords' => $resultado['total']
            ],
            'filtros' => $filtros
        ];

        return view('header', $data)
            . view('navbar')
            . view('admin/configuracion/index', $data)
            . view('footer_admin');
    }

    /**
     * Muestra el formulario para crear una nueva configuración
     */
    public function crear()
    {
        if (!session('logueado') || session('user_role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Acceso denegado');
        }

        $data = [
            'title' => 'Crear Configuración',
            'tipos' => ['texto', 'numero', 'email', 'url', 'telefono', 'direccion', 'horario'],
            'secciones' => ['general', 'navbar', 'footer', 'contacto', 'redes_sociales']
        ];

        return view('header', $data)
            . view('navbar')
            . view('admin/configuracion/crear', $data)
            . view('footer_admin');
    }

    /**
     * Guarda una nueva configuración
     */
    public function guardar()
    {
        if (!session('logueado') || session('user_role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Acceso denegado');
        }

        $data = [
            'clave' => $this->request->getPost('clave'),
            'valor' => $this->request->getPost('valor'),
            'descripcion' => $this->request->getPost('descripcion'),
            'tipo' => $this->request->getPost('tipo'),
            'seccion' => $this->request->getPost('seccion'),
            'activo' => $this->request->getPost('activo') ?? 1
        ];

        if ($this->configuracionModel->insert($data)) {
            return redirect()->to('/admin/configuracion')->with('success', 'Configuración creada exitosamente');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al crear la configuración');
        }
    }

    /**
     * Muestra el formulario para editar una configuración
     */
    public function editar($id)
    {
        if (!session('logueado') || session('user_role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Acceso denegado');
        }

        $configuracion = $this->configuracionModel->find($id);
        
        if (!$configuracion) {
            return redirect()->to('/admin/configuracion')->with('error', 'Configuración no encontrada');
        }

        $data = [
            'title' => 'Editar Configuración',
            'configuracion' => $configuracion,
            'tipos' => ['texto', 'numero', 'email', 'url', 'telefono', 'direccion', 'horario'],
            'secciones' => ['general', 'navbar', 'footer', 'contacto', 'redes_sociales']
        ];

        return view('header', $data)
            . view('navbar')
            . view('admin/configuracion/editar', $data)
            . view('footer_admin');
    }

    /**
     * Actualiza una configuración
     */
    public function actualizar($id)
    {
        if (!session('logueado') || session('user_role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Acceso denegado');
        }

        $data = [
            'clave' => $this->request->getPost('clave'),
            'valor' => $this->request->getPost('valor'),
            'descripcion' => $this->request->getPost('descripcion'),
            'tipo' => $this->request->getPost('tipo'),
            'seccion' => $this->request->getPost('seccion'),
            'activo' => $this->request->getPost('activo') ?? 1
        ];

        if ($this->configuracionModel->update($id, $data)) {
            return redirect()->to('/admin/configuracion')->with('success', 'Configuración actualizada exitosamente');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar la configuración');
        }
    }

    /**
     * Elimina una configuración
     */
    public function eliminar($id)
    {
        if (!session('logueado') || session('user_role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Acceso denegado');
        }

        if ($this->configuracionModel->delete($id)) {
            return redirect()->to('/admin/configuracion')->with('success', 'Configuración eliminada exitosamente');
        } else {
            return redirect()->to('/admin/configuracion')->with('error', 'Error al eliminar la configuración');
        }
    }

    /**
     * Cambia el estado activo/inactivo de una configuración
     */
    public function toggleEstado($id)
    {
        if (!session('logueado') || session('user_role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Acceso denegado');
        }

        $configuracion = $this->configuracionModel->find($id);
        
        if (!$configuracion) {
            return redirect()->to('/admin/configuracion')->with('error', 'Configuración no encontrada');
        }

        $nuevoEstado = $configuracion['activo'] ? 0 : 1;
        
        if ($this->configuracionModel->update($id, ['activo' => $nuevoEstado])) {
            $mensaje = $nuevoEstado ? 'Configuración activada' : 'Configuración desactivada';
            return redirect()->to('/admin/configuracion')->with('success', $mensaje);
        } else {
            return redirect()->to('/admin/configuracion')->with('error', 'Error al cambiar el estado');
        }
    }

    /**
     * Muestra una vista rápida para editar configuraciones comunes
     */
    public function vistaRapida()
    {
        if (!session('logueado') || session('user_role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Acceso denegado');
        }

        $data = [
            'title' => 'Configuración Rápida',
            'general' => $this->configuracionModel->getGeneral(),
            'contacto' => $this->configuracionModel->getContacto(),
            'redes_sociales' => $this->configuracionModel->getRedesSociales(),
            'footer' => $this->configuracionModel->getFooter(),
            'navbar' => $this->configuracionModel->getNavbar()
        ];

        return view('header', $data)
            . view('navbar')
            . view('admin/configuracion/vista_rapida', $data)
            . view('footer_admin');
    }

    /**
     * Actualiza configuraciones desde la vista rápida
     */
    public function actualizarRapida()
    {
        if (!session('logueado') || session('user_role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Acceso denegado');
        }

        $postData = $this->request->getPost();
        $actualizaciones = 0;

        foreach ($postData as $clave => $valor) {
            if ($clave !== 'csrf_test_name' && $this->configuracionModel->existe($clave)) {
                if ($this->configuracionModel->actualizarValor($clave, $valor)) {
                    $actualizaciones++;
                }
            }
        }

        if ($actualizaciones > 0) {
            return redirect()->to('/admin/configuracion/vista-rapida')->with('success', "Se actualizaron {$actualizaciones} configuraciones");
        } else {
            return redirect()->to('/admin/configuracion/vista-rapida')->with('error', 'No se actualizó ninguna configuración');
        }
    }

    /**
     * Muestra la página de configuración del punto de partida
     */
    public function puntoPartida()
    {
        if (!session('logueado') || session('user_role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Acceso denegado');
        }

        $puntoPartida = $this->configuracionModel->getPuntoPartidaCompleto();
        
        $data = [
            'title' => 'Configurar Punto de Partida',
            'puntoPartida' => $puntoPartida
        ];

        return view('header', $data)
            . view('navbar')
            . view('admin/configuracion/punto_partida', $data)
            . view('footer_admin');
    }

    /**
     * Actualiza la configuración del punto de partida
     */
    public function actualizarPuntoPartida()
    {
        if (!session('logueado') || session('user_role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Acceso denegado');
        }

        // Obtener y validar coordenadas
        $latitud = $this->request->getPost('latitud');
        $longitud = $this->request->getPost('longitud');
        $nombre = $this->request->getPost('nombre');
        $direccion = $this->request->getPost('direccion');

        // Validaciones básicas
        if (empty($nombre) || strlen($nombre) < 3) {
            return redirect()->back()->withInput()->with('error', 'El nombre del restaurante debe tener al menos 3 caracteres.');
        }

        if (empty($direccion) || strlen($direccion) < 10) {
            return redirect()->back()->withInput()->with('error', 'La dirección debe tener al menos 10 caracteres.');
        }

        // Validar que las coordenadas sean números
        if (!is_numeric($latitud) || !is_numeric($longitud)) {
            return redirect()->back()->withInput()->with('error', 'Las coordenadas deben ser números válidos.');
        }

        // Convertir a float y validar rangos
        $lat = (float) $latitud;
        $lng = (float) $longitud;

        // Validar rangos de latitud y longitud para Argentina
        if ($lat < -55 || $lat > -22) {
            return redirect()->back()->withInput()->with('error', 'La latitud debe estar en el rango de Argentina (-55 a -22).');
        }

        if ($lng < -73 || $lng > -54) {
            return redirect()->back()->withInput()->with('error', 'La longitud debe estar en el rango de Argentina (-73 a -54).');
        }

        // Redondear coordenadas a 6 decimales para evitar problemas de precisión
        $lat = round($lat, 6);
        $lng = round($lng, 6);

        $data = [
            'punto_partida_latitud' => $lat,
            'punto_partida_longitud' => $lng,
            'punto_partida_direccion' => $direccion,
            'punto_partida_nombre' => $nombre
        ];

        $actualizado = true;
        foreach ($data as $clave => $valor) {
            if (!$this->configuracionModel->actualizarValor($clave, $valor)) {
                $actualizado = false;
            }
        }

        if ($actualizado) {
            return redirect()->back()->with('success', 'Punto de partida actualizado exitosamente');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el punto de partida');
        }
    }

    /**
     * Muestra la configuración del mapa de seguimiento
     */
    public function mapaSeguimiento()
    {
        if (!session('logueado') || session('user_role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Acceso denegado');
        }

        $configuracion = $this->configuracionModel->getConfiguracionMapaSeguimiento();

        $data = [
            'title' => 'Configuración del Mapa de Seguimiento',
            'configuracion' => $configuracion
        ];

        return view('header', $data)
            . view('navbar')
            . view('admin/configuracion/mapa_seguimiento', $data)
            . view('footer_admin');
    }

    /**
     * Actualiza la configuración del mapa de seguimiento
     */
    public function actualizarMapaSeguimiento()
    {
        if (!session('logueado') || session('user_role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Acceso denegado');
        }

        $configuracion = [
            'activo' => $this->request->getPost('activo') ?? '0',
            'tiempo_actualizacion' => $this->request->getPost('tiempo_actualizacion') ?? '30',
            'mostrar_ruta' => $this->request->getPost('mostrar_ruta') ?? '0',
            'zoom_default' => $this->request->getPost('zoom_default') ?? '15'
        ];

        if ($this->configuracionModel->actualizarConfiguracionMapaSeguimiento($configuracion)) {
            return redirect()->to('/admin/configuracion/mapa-seguimiento')->with('success', 'Configuración del mapa de seguimiento actualizada exitosamente');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar la configuración del mapa de seguimiento');
        }
    }
} 