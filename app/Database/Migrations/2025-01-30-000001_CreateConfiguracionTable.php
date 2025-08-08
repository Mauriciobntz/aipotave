<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConfiguracionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'clave' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'valor' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tipo' => [
                'type' => 'ENUM',
                'constraint' => ['texto', 'numero', 'email', 'url', 'telefono', 'direccion', 'horario'],
                'default' => 'texto',
            ],
            'seccion' => [
                'type' => 'ENUM',
                'constraint' => ['general', 'navbar', 'footer', 'contacto', 'redes_sociales'],
                'default' => 'general',
            ],
            'activo' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'fecha_creacion' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'fecha_actualizacion' => [
                'type' => 'DATETIME',
                'null' => true,
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('clave');
        $this->forge->createTable('configuracion');

        // Insertar datos iniciales
        $this->db->table('configuracion')->insertBatch([
            // Configuración general
            [
                'clave' => 'nombre_restaurante',
                'valor' => 'Mi Restaurante',
                'descripcion' => 'Nombre del restaurante que aparece en el navbar y footer',
                'tipo' => 'texto',
                'seccion' => 'general',
                'activo' => 1,
            ],
            [
                'clave' => 'slogan',
                'valor' => 'Ofrecemos los mejores platos con ingredientes frescos y de la más alta calidad. Tu satisfacción es nuestra prioridad.',
                'descripcion' => 'Slogan o descripción del restaurante',
                'tipo' => 'texto',
                'seccion' => 'general',
                'activo' => 1,
            ],
            [
                'clave' => 'logo_icon',
                'valor' => 'fas fa-utensils',
                'descripcion' => 'Clase CSS del ícono del logo (FontAwesome)',
                'tipo' => 'texto',
                'seccion' => 'navbar',
                'activo' => 1,
            ],
            
            // Información de contacto
            [
                'clave' => 'direccion',
                'valor' => 'Av. Principal 123, Ciudad',
                'descripcion' => 'Dirección física del restaurante',
                'tipo' => 'direccion',
                'seccion' => 'contacto',
                'activo' => 1,
            ],
            [
                'clave' => 'telefono',
                'valor' => '+1 234 567 8900',
                'descripcion' => 'Número de teléfono del restaurante',
                'tipo' => 'telefono',
                'seccion' => 'contacto',
                'activo' => 1,
            ],
            [
                'clave' => 'email',
                'valor' => 'info@mirestaurante.com',
                'descripcion' => 'Dirección de email del restaurante',
                'tipo' => 'email',
                'seccion' => 'contacto',
                'activo' => 1,
            ],
            [
                'clave' => 'horarios',
                'valor' => 'Lun-Dom: 11:00 - 23:00',
                'descripcion' => 'Horarios de atención del restaurante',
                'tipo' => 'horario',
                'seccion' => 'contacto',
                'activo' => 1,
            ],
            [
                'clave' => 'whatsapp',
                'valor' => '1234567890',
                'descripcion' => 'Número de WhatsApp para contacto',
                'tipo' => 'telefono',
                'seccion' => 'contacto',
                'activo' => 1,
            ],
            
            // Redes sociales
            [
                'clave' => 'facebook_url',
                'valor' => '#',
                'descripcion' => 'URL del perfil de Facebook',
                'tipo' => 'url',
                'seccion' => 'redes_sociales',
                'activo' => 1,
            ],
            [
                'clave' => 'instagram_url',
                'valor' => '#',
                'descripcion' => 'URL del perfil de Instagram',
                'tipo' => 'url',
                'seccion' => 'redes_sociales',
                'activo' => 1,
            ],
            [
                'clave' => 'twitter_url',
                'valor' => '#',
                'descripcion' => 'URL del perfil de Twitter',
                'tipo' => 'url',
                'seccion' => 'redes_sociales',
                'activo' => 1,
            ],
            [
                'clave' => 'whatsapp_url',
                'valor' => 'https://wa.me/1234567890',
                'descripcion' => 'URL de WhatsApp para contacto directo',
                'tipo' => 'url',
                'seccion' => 'redes_sociales',
                'activo' => 1,
            ],
            
            // Footer
            [
                'clave' => 'copyright_text',
                'valor' => 'Mi Restaurante. Todos los derechos reservados.',
                'descripcion' => 'Texto de copyright del footer',
                'tipo' => 'texto',
                'seccion' => 'footer',
                'activo' => 1,
            ],
            [
                'clave' => 'desarrollador_text',
                'valor' => 'Max Clorinda - Sistema de Delivery',
                'descripcion' => 'Texto del desarrollador en el footer',
                'tipo' => 'texto',
                'seccion' => 'footer',
                'activo' => 1,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('configuracion');
    }
} 