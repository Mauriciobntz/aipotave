<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\HistorialEstadosModel;

class LimpiarHistorial extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'historial:limpiar';
    protected $description = 'Limpia registros con estados vacíos o nulos en el historial de estados';

    public function run(array $params)
    {
        $historialModel = new HistorialEstadosModel();
        
        CLI::write('Limpiando registros con estados vacíos o nulos...', 'yellow');
        
        // Contar registros problemáticos antes de limpiar
        $registrosProblematicos = $historialModel->where('estado_anterior IS NULL OR estado_anterior = "" OR estado_nuevo IS NULL OR estado_nuevo = ""')->countAllResults();
        
        if ($registrosProblematicos > 0) {
            CLI::write("Encontrados {$registrosProblematicos} registros problemáticos.", 'red');
            
            // Eliminar registros problemáticos
            $resultado = $historialModel->where('estado_anterior IS NULL OR estado_anterior = "" OR estado_nuevo IS NULL OR estado_nuevo = ""')->delete();
            
            if ($resultado) {
                CLI::write("Se eliminaron {$resultado} registros problemáticos.", 'green');
            } else {
                CLI::write('Error al eliminar registros problemáticos.', 'red');
            }
        } else {
            CLI::write('No se encontraron registros problemáticos.', 'green');
        }
        
        // Mostrar estadísticas finales
        $totalRegistros = $historialModel->countAllResults();
        CLI::write("Total de registros en historial: {$totalRegistros}", 'blue');
        
        CLI::write('Limpieza completada.', 'green');
    }
}
