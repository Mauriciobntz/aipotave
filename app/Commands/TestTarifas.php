<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\TarifaEnvioModel;

class TestTarifas extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'test:tarifas';
    protected $description = 'Probar cálculo de tarifas con diferentes distancias';

    public function run(array $params)
    {
        $tarifaModel = new TarifaEnvioModel();
        
        CLI::write('=== Probando Cálculo de Tarifas ===', 'green');
        
        // Probar con la distancia específica del problema
        $distancia = 2.9;
        CLI::write("Probando con distancia: {$distancia} km", 'yellow');
        
        $resultado = $tarifaModel->calcularCostoEnvio($distancia);
        
        CLI::write("Resultado:", 'cyan');
        CLI::write("- Costo: $" . number_format($resultado['costo'], 0, ',', '.'), 'white');
        CLI::write("- Tarifa: " . $resultado['tarifa']['nombre'], 'white');
        CLI::write("- Rango: {$resultado['tarifa']['distancia_minima']} - {$resultado['tarifa']['distancia_maxima']} km", 'white');
        
        // Probar con otras distancias
        CLI::newLine();
        CLI::write('=== Probando Otras Distancias ===', 'green');
        
        $distancias = [0.5, 1.5, 2.5, 3.5, 4.5];
        
        foreach ($distancias as $dist) {
            $result = $tarifaModel->calcularCostoEnvio($dist);
            CLI::write("{$dist} km -> $" . number_format($result['costo'], 0, ',', '.') . " ({$result['tarifa']['nombre']})", 'yellow');
        }
    }
}
