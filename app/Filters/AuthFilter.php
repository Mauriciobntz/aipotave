<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\Services;

/**
 * Filtro de autenticación y autorización por rol.
 */
class AuthFilter implements FilterInterface
{
    /**
     * Si no está logueado, redirige a login. Si la ruta requiere rol, verifica el rol.
     * Para usar: $routes->group('admin', ['filter' => 'auth:admin'], ...)
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $rolRequerido = $arguments[0] ?? null;
        
        if (!$session->get('logueado')) {
            return redirect()->to(base_url('login'));
        }
        
        if ($rolRequerido) {
            $rolUsuario = $session->get('user_role');
            $tipoUsuario = $session->get('user_type');
            
            // Permitir acceso si el rol coincide, independientemente del tipo de usuario
            // (empleados con rol "repartidor" pueden acceder a rutas de repartidor)
            if ($rolUsuario !== $rolRequerido) {
                return redirect()->to(base_url('denegado'));
            }
        }
        
        // Si pasa, continúa
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hace nada después
    }
} 