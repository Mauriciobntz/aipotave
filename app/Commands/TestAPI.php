<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TestAPI extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'test:api';
    protected $description = 'Probar la API de cálculo de tarifas';

    public function run(array $params)
    {
        CLI::write('=== Probando API de Cálculo de Tarifas ===', 'green');
        
        // Simular una petición POST a la API
        $url = 'http://localhost/max/envio/calcular-costo';
        $data = ['distancia' => 2.9];
        
        CLI::write("URL: {$url}", 'yellow');
        CLI::write("Datos: " . json_encode($data), 'yellow');
        
        // Usar cURL para probar la API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        CLI::write("HTTP Code: {$httpCode}", 'cyan');
        
        if ($error) {
            CLI::error("Error cURL: {$error}");
            return;
        }
        
        CLI::write("Respuesta:", 'cyan');
        CLI::write($response, 'white');
        
        // Intentar parsear como JSON
        $jsonResponse = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            CLI::write("JSON válido:", 'green');
            CLI::write(json_encode($jsonResponse, JSON_PRETTY_PRINT), 'white');
        } else {
            CLI::error("No es JSON válido: " . json_last_error_msg());
        }
    }
}
