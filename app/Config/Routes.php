<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


//######################## Rutas API ########################
$routes->group('api', function($routes) {
    // Rutas para pedidos
    $routes->match(['put', 'post'], 'pedidos/(:segment)/estado', 'Api\PedidoController::actualizarEstado/$1');
    $routes->get('pedidos/(:segment)/estado', 'Api\PedidoController::obtenerEstado/$1');
});

//######################## Rutas Debug ########################
$routes->get('debug/detalles/(:num)', 'DebugController::debugDetalles/$1');
$routes->get('debug/detalles', 'DebugController::debugDetalles');
$routes->get('debug/pedidos', 'DebugController::debugTodosPedidos');
$routes->get('debug/estructura', 'DebugController::debugEstructura');

//######################## Rutas Menu ########################
$routes->get('/', 'MenuController::index');
$routes->get('producto/(:num)', 'MenuController::producto/$1');
$routes->get('combo/(:num)', 'MenuController::combo/$1');
$routes->get('producto/detalle/(:num)/(:segment)', 'MenuController::producto/$1');

//######################## Rutas Carrito ########################
$routes->get('carrito', 'CarritoController::verCarrito');
$routes->post('carrito/agregar', 'CarritoController::agregarProducto');
$routes->post('carrito/agregar-ajax', 'CarritoController::agregarAjax');
$routes->post('carrito/actualizar', 'CarritoController::actualizarCantidad');
$routes->post('carrito/actualizar-cantidad', 'CarritoController::actualizarCantidad');
$routes->get('carrito/eliminar/(:segment)/(:num)', 'CarritoController::eliminarItem/$1/$2');
$routes->get('carrito/vaciar', 'CarritoController::vaciarCarrito');
$routes->get('carrito/comprar', 'CarritoController::comprar');
$routes->get('checkout/confirmar', 'CheckoutController::confirmar');
$routes->post('checkout/confirmar', 'CheckoutController::confirmar');
$routes->get('checkout/formulario', 'CheckoutController::formulario');
$routes->post('checkout/procesar', 'CheckoutController::procesar');
$routes->get('checkout/exito/(:segment)', 'CheckoutController::exito/$1');
$routes->get('pedido/seguimiento/(:segment)', 'PedidoController::seguimiento/$1');
$routes->get('pedido/seguimiento', 'PedidoController::index');

// Rutas de seguimiento en tiempo real
$routes->get('seguimiento', 'SeguimientoController::seguimiento');
$routes->get('seguimiento/(:segment)', 'SeguimientoController::seguimiento/$1');
$routes->get('api/seguimiento/ubicacion/(:num)', 'SeguimientoController::ubicacionRepartidor/$1');
$routes->get('api/seguimiento/pedido/(:segment)', 'SeguimientoController::infoPedido/$1');

//######################## Rutas Calificaciones ########################
$routes->get('calificar/(:segment)', 'CalificacionController::calificar/$1');
$routes->post('calificar/procesar', 'CalificacionController::procesarCalificacion');

//######################## Rutas de administrador (requieren rol admin) ########################

$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    $routes->get('dashboard', 'PanelController::dashboard');
    $routes->get('panel', 'PanelController::dashboard'); // Alias para compatibilidad
    $routes->get('pedidos', 'PanelController::pedidos');
    $routes->get('pedidos/ver/(:num)', 'PanelController::detallePedido/$1');
    $routes->get('pedidos/(:num)', 'PanelController::detallePedido/$1');
    // Ruta de prueba temporal sin filtro
    $routes->get('test/pedido/(:num)', 'PanelController::detallePedido/$1');
    $routes->post('cambiar-estado', 'PanelController::cambiarEstado');
    $routes->post('asignar-repartidor', 'PanelController::asignarRepartidor');
    
    // Productos
    $routes->get('productos/listar', 'ProductoController::listar');
    $routes->get('productos/agregar', 'ProductoController::agregarProducto');
    $routes->post('productos/guardar', 'ProductoController::guardarProducto');
    $routes->get('productos/editar/(:num)', 'ProductoController::editarProducto/$1');
    $routes->post('productos/actualizar/(:num)', 'ProductoController::actualizarProducto/$1');
    $routes->get('productos/activar/(:num)', 'ProductoController::activar/$1');
    $routes->get('productos/desactivar/(:num)', 'ProductoController::desactivar/$1');
    $routes->get('productos/eliminar/(:num)', 'ProductoController::eliminar/$1');
    $routes->get('productos/subcategorias/(:num)', 'ProductoController::getSubcategorias/$1');
    
    // Categorías
    $routes->get('categorias', 'CategoriaController::listar');
    $routes->get('categorias/agregar', 'CategoriaController::agregar');
    $routes->post('categorias/guardar', 'CategoriaController::guardar');
    $routes->get('categorias/editar/(:num)', 'CategoriaController::editar/$1');
    $routes->post('categorias/actualizar/(:num)', 'CategoriaController::actualizar/$1');
    $routes->get('categorias/eliminar/(:num)', 'CategoriaController::eliminar/$1');
    
    // Subcategorías
    $routes->get('subcategorias', 'SubcategoriaController::listar');
    $routes->get('subcategorias/agregar', 'SubcategoriaController::agregar');
    $routes->post('subcategorias/guardar', 'SubcategoriaController::guardar');
    $routes->get('subcategorias/editar/(:num)', 'SubcategoriaController::editar/$1');
    $routes->post('subcategorias/actualizar/(:num)', 'SubcategoriaController::actualizar/$1');
    $routes->get('subcategorias/eliminar/(:num)', 'SubcategoriaController::eliminar/$1');
    
    // Combos
    $routes->get('combos/listar', 'ComboController::listar');
    $routes->get('combos/crear', 'ComboController::agregarCombo');
    $routes->post('combos/guardar', 'ComboController::guardarCombo');
    $routes->get('combos/editar/(:num)', 'ComboController::editarCombo/$1');
    $routes->post('combos/actualizar/(:num)', 'ComboController::actualizarCombo/$1');
    $routes->get('combos/eliminar/(:num)', 'ComboController::eliminar/$1');

    // Viandas
    $routes->get('viandas/listar', 'ViandaController::listar');
    $routes->get('viandas/crear', 'ViandaController::agregarVianda');
    $routes->post('viandas/guardar', 'ViandaController::guardarVianda');
    $routes->get('viandas/editar/(:num)', 'ViandaController::editarVianda/$1');
    $routes->post('viandas/actualizar/(:num)', 'ViandaController::actualizarVianda/$1');
    $routes->get('viandas/eliminar/(:num)', 'ViandaController::eliminar/$1');
    $routes->match(['get', 'post'], 'viandas/stock/(:num)', 'ViandaController::stock/$1');

    // Repartidores
    $routes->get('repartidores/listar', 'RepartidorAdminController::listar');
    $routes->get('repartidores/crear', 'RepartidorAdminController::agregar');
    $routes->post('repartidores/guardar', 'RepartidorAdminController::guardar');

    // Slides
    $routes->get('slides', 'Admin\SlidesController::index');
    $routes->get('slides/crear', 'Admin\SlidesController::crear');
    $routes->post('slides/guardar', 'Admin\SlidesController::guardar');
    $routes->get('slides/editar/(:num)', 'Admin\SlidesController::editar/$1');
    $routes->post('slides/actualizar/(:num)', 'Admin\SlidesController::actualizar/$1');
    $routes->get('slides/eliminar/(:num)', 'Admin\SlidesController::eliminar/$1');
    $routes->get('slides/toggle-estado/(:num)', 'Admin\SlidesController::toggleEstado/$1');
    $routes->post('slides/reordenar', 'Admin\SlidesController::reordenar');
    $routes->get('repartidores/editar/(:num)', 'RepartidorAdminController::editar/$1');
    $routes->post('repartidores/actualizar/(:num)', 'RepartidorAdminController::actualizar/$1');
    $routes->get('repartidores/eliminar/(:num)', 'RepartidorAdminController::eliminar/$1');

    // Calificaciones
    $routes->get('calificaciones/listar', 'CalificacionController::listar');
    $routes->get('calificaciones/(:num)', 'CalificacionController::detalle/$1');

    // Notificaciones
    $routes->get('notificaciones/listar', 'NotificacionController::listar');
    $routes->get('notificaciones/(:num)', 'NotificacionController::detalle/$1');
    $routes->post('notificaciones/actualizar-estado/(:num)', 'NotificacionController::actualizarEstado/$1');
    $routes->get('notificaciones/reenviar/(:num)', 'NotificacionController::reenviar/$1');
    $routes->get('notificaciones/estadisticas', 'NotificacionController::estadisticas');

    // Stock
    $routes->get('stock/listar', 'StockController::listar');
    $routes->get('stock/actualizar/(:num)', 'StockController::actualizar/$1');
    $routes->post('stock/guardar', 'StockController::guardar');
    $routes->get('stock/estadisticas', 'StockController::estadisticas');

    // Estadísticas
    $routes->get('estadisticas', 'EstadisticasController::dashboard');
    $routes->get('estadisticas/exportar-excel', 'EstadisticasController::exportarExcel');

    // Configuración del sitio
    $routes->get('configuracion', 'ConfiguracionController::index');
    $routes->get('configuracion/crear', 'ConfiguracionController::crear');
    $routes->post('configuracion/guardar', 'ConfiguracionController::guardar');
    $routes->get('configuracion/editar/(:num)', 'ConfiguracionController::editar/$1');
    $routes->post('configuracion/actualizar/(:num)', 'ConfiguracionController::actualizar/$1');
    $routes->get('configuracion/eliminar/(:num)', 'ConfiguracionController::eliminar/$1');
    $routes->get('configuracion/toggle-estado/(:num)', 'ConfiguracionController::toggleEstado/$1');
    $routes->get('configuracion/vista-rapida', 'ConfiguracionController::vistaRapida');
    $routes->post('configuracion/actualizar-rapida', 'ConfiguracionController::actualizarRapida');
    $routes->get('configuracion/punto-partida', 'ConfiguracionController::puntoPartida');
    $routes->post('configuracion/actualizar-punto-partida', 'ConfiguracionController::actualizarPuntoPartida');
    $routes->get('configuracion/mapa-seguimiento', 'ConfiguracionController::mapaSeguimiento');
    $routes->post('configuracion/actualizar-mapa-seguimiento', 'ConfiguracionController::actualizarMapaSeguimiento');
    
    // Tarifas de Envío
    $routes->get('tarifas-envio', 'Admin\TarifasEnvioController::index');
    $routes->get('tarifas-envio/crear', 'Admin\TarifasEnvioController::crear');
    $routes->post('tarifas-envio/guardar', 'Admin\TarifasEnvioController::guardar');
    $routes->get('tarifas-envio/editar/(:num)', 'Admin\TarifasEnvioController::editar/$1');
    $routes->post('tarifas-envio/actualizar/(:num)', 'Admin\TarifasEnvioController::actualizar/$1');
    $routes->get('tarifas-envio/eliminar/(:num)', 'Admin\TarifasEnvioController::eliminar/$1');
    $routes->post('tarifas-envio/cambiar-estado/(:num)', 'Admin\TarifasEnvioController::cambiarEstado/$1');
    $routes->post('tarifas-envio/calcular-costo', 'Admin\TarifasEnvioController::calcularCosto');
});

//######################## Rutas de cocina (requieren rol cocina) ########################
$routes->group('cocina', ['filter' => 'auth:cocina'], function($routes) {
    $routes->get('pedidos', 'CocinaController::pedidos');
    $routes->get('pedidos/(:num)', 'CocinaController::detalle/$1');
    $routes->post('pedidos/cambiar-estado/(:num)', 'CocinaController::cambiarEstado/$1');
    $routes->get('repartidores/disponibles', 'CocinaController::obtenerRepartidoresDisponiblesAPI');
    $routes->get('productos', 'CocinaController::productos');
    $routes->post('productos/cambiar-estado/(:num)', 'CocinaController::cambiarEstadoProducto/$1');
    $routes->post('productos/desactivar-categoria/(:num)', 'CocinaController::desactivarProductosCategoria/$1');
    $routes->post('productos/desactivar-subcategoria/(:num)', 'CocinaController::desactivarProductosSubcategoria/$1');
    $routes->get('estadisticas', 'CocinaController::estadisticas');
    $routes->get('pantalla', 'CocinaController::pantalla');
});

// Ruta de prueba para repartidores (sin autenticación)
$routes->get('test/repartidores', 'CocinaController::testRepartidoresAPI');


//######################## Rutas de repartidor (requieren rol repartidor) ########################
$routes->group('repartidor', ['filter' => 'auth:repartidor'], function($routes) {
    // Rutas del repartidor
    $routes->get('pedidos', 'RepartidorController::pedidos');
    $routes->get('pedidos/(:num)', 'RepartidorController::detalle/$1');
    $routes->post('pedidos/cambiar-estado', 'RepartidorController::cambiarEstado');
    $routes->post('pedidos/marcar-pago-recibido', 'RepartidorController::marcarPagoRecibido');
    $routes->post('actualizar-ubicacion', 'RepartidorController::actualizarUbicacion');
    $routes->get('estadisticas', 'RepartidorController::estadisticas');
});

$routes->get('api/ubicacion/(:num)/(:num)', 'ApiController::ubicacion/$1/$2');

// Rutas de Google Maps
$routes->get('google-maps', 'GoogleMapsController::index');
$routes->post('google-maps/geocode', 'GoogleMapsController::geocode');
$routes->post('google-maps/reverse-geocode', 'GoogleMapsController::reverseGeocode');
$routes->post('google-maps/directions', 'GoogleMapsController::directions');
$routes->get('google-maps/status', 'GoogleMapsController::status');

// Ruta de ejemplo para Google Maps
$routes->get('googlemaps', 'GoogleMapsController::index');

// Rutas de Estadísticas con Mapas
$routes->get('estadisticas-mapa', 'EstadisticasMapaController::index');
$routes->get('estadisticas-mapa/api', 'EstadisticasMapaController::api');
$routes->get('estadisticas-mapa/exportar', 'EstadisticasMapaController::exportar');

// Rutas de Envío
$routes->post('envio/calcular-costo', 'EnvioController::calcularCosto');
$routes->post('envio/validar-zona', 'EnvioController::validarZona');
$routes->get('envio/tarifas', 'EnvioController::tarifas');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::procesarLogin');
$routes->get('logout', 'AuthController::logout');
$routes->get('denegado', 'AuthController::denegado');

// Ruta temporal para actualizar categorías de productos
$routes->get('actualizar-categorias', 'Home::actualizarCategorias');


