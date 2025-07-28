<?php
namespace App\Controllers;

use App\Models\EmpleadoModel;
use App\Models\RepartidorModel;
use CodeIgniter\Controller;

/**
 * Controlador de autenticación y cierre de sesión.
 */
class AuthController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function login()
    {
        $data = [
            'title' => 'Iniciar sesión'
        ];
        return view('header', $data)
            . view('navbar')
            . view('auth/login')
            . view('footer');
    }

    /**
     * Procesa el login de admin, cocina o repartidor.
     */
    public function procesarLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Buscar en empleados
        $empleadoModel = new EmpleadoModel();
        $empleado = $empleadoModel->where('email', $email)->first();

        if ($empleado && $password === $empleado['password'] && $empleado['activo']) {
            session()->set([
                'user_id' => $empleado['id'],
                'user_name' => $empleado['nombre'],
                'user_email' => $empleado['email'],
                'user_role' => $empleado['rol'],
                'user_type' => 'empleado',
                'logueado' => true
            ]);

            // Redirigir según el rol
            switch ($empleado['rol']) {
                case 'admin':
                    return redirect()->to(base_url('admin/panel'));
                case 'cocina':
                    return redirect()->to(base_url('cocina/pedidos'));
                default:
                    return redirect()->to(base_url('admin/panel'));
            }
        }

        // Buscar en repartidores
        $repartidorModel = new RepartidorModel();
        $repartidor = $repartidorModel->where('email', $email)->first();

        if ($repartidor && $password === $repartidor['password'] && $repartidor['activo']) {
            session()->set([
                'user_id' => $repartidor['id'],
                'user_name' => $repartidor['nombre'],
                'user_email' => $repartidor['email'],
                'user_role' => 'repartidor',
                'user_type' => 'repartidor',
                'logueado' => true
            ]);

            return redirect()->to(base_url('repartidor/pedidos'));
        }

        // Si no se encontró usuario válido
        session()->setFlashdata('error', 'Credenciales inválidas');
        return redirect()->to(base_url('login'));
    }

    /**
     * Cierra la sesión y redirige al login.
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    /**
     * Muestra la página de acceso denegado.
     */
    public function denegado()
    {
        $data = [
            'title' => 'Acceso Denegado'
        ];
        return view('header', $data)
            . view('navbar')
            . view('denegado')
            . view('footer');
    }
} 