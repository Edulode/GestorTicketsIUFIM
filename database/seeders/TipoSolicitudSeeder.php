<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoSolicitud;
use Illuminate\Support\Facades\DB;

class TipoSolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_solicituds')->insert([
            ['tipo_solicitud' => 'Apoyo para evento', 'categoria_servicio_id' => 2],
            ['tipo_solicitud' => 'Asesoría', 'categoria_servicio_id' => 3],
            ['tipo_solicitud' => 'Aulas-instalación de hardware', 'categoria_servicio_id' => 4],
            ['tipo_solicitud' => 'Aulas-mantenimiento a hardware', 'categoria_servicio_id' => 4],
            ['tipo_solicitud' => 'Aulas-revisión de hardware', 'categoria_servicio_id' => 4],
            ['tipo_solicitud' => 'Aulas-revisión de internet', 'categoria_servicio_id' => 4],
            ['tipo_solicitud' => 'Aviso', 'categoria_servicio_id' => 16],
            ['tipo_solicitud' => 'Cableado-instalación', 'categoria_servicio_id' => 5],
            ['tipo_solicitud' => 'Cableado-revisión', 'categoria_servicio_id' => 5],
            ['tipo_solicitud' => 'Certificaciones', 'categoria_servicio_id' => 6],
            ['tipo_solicitud' => 'Correo-revisar o enviar mensaje', 'categoria_servicio_id' => 8],
            ['tipo_solicitud' => 'Cuenta de correo-crear o suspender', 'categoria_servicio_id' => 8],
            ['tipo_solicitud' => 'Cuenta de correo-bloquear o desbloquear', 'categoria_servicio_id' => 8],
            ['tipo_solicitud' => 'Evidencias-entregar', 'categoria_servicio_id' => 11],
            ['tipo_solicitud' => 'Extensión telefónica-configurar', 'categoria_servicio_id' => 19],
            ['tipo_solicitud' => 'Extensión telefónica-revisar', 'categoria_servicio_id' => 19],
            ['tipo_solicitud' => 'Línea telefónica-revisar', 'categoria_servicio_id' => 19],
            ['tipo_solicitud' => 'Conmutador-revisar', 'categoria_servicio_id' => 19],
            ['tipo_solicitud' => 'Hardware-asignación', 'categoria_servicio_id' => 10],
            ['tipo_solicitud' => 'Hardware-entrada o salida', 'categoria_servicio_id' => 10],
            ['tipo_solicitud' => 'Hardware-instalación o configuración', 'categoria_servicio_id' => 10],
            ['tipo_solicitud' => 'Hardware-mantenimiento', 'categoria_servicio_id' => 10],
            ['tipo_solicitud' => 'Hardware-resguardo', 'categoria_servicio_id' => 10],
            ['tipo_solicitud' => 'Hardware-revisión', 'categoria_servicio_id' => 10],
            ['tipo_solicitud' => 'Internet-configurar permisos', 'categoria_servicio_id' => 12],
            ['tipo_solicitud' => 'Internet-revisar conexión', 'categoria_servicio_id' => 12],
            ['tipo_solicitud' => 'Llamada-devolver llamada', 'categoria_servicio_id' => 16],
            ['tipo_solicitud' => 'Llamada-hablar con Jefe de TI', 'categoria_servicio_id' => 16],
            ['tipo_solicitud' => 'Llamada-vuelve a llamar', 'categoria_servicio_id' => 16],
            ['tipo_solicitud' => 'Ofrece servicios', 'categoria_servicio_id' => 2],
            ['tipo_solicitud' => 'Pregunta genérica', 'categoria_servicio_id' => 16],
            ['tipo_solicitud' => 'Presupuesto', 'categoria_servicio_id' => 11],
            ['tipo_solicitud' => 'Requisiciones-recoger o entregar', 'categoria_servicio_id' => 16],
            ['tipo_solicitud' => 'Reunión', 'categoria_servicio_id' => 16],
            ['tipo_solicitud' => 'Revisar inventario', 'categoria_servicio_id' => 16],
            ['tipo_solicitud' => 'Salas de cómputo-abrir o cerrar', 'categoria_servicio_id' => 15],
            ['tipo_solicitud' => 'Salas de cómputo-configuración de red', 'categoria_servicio_id' => 15],
            ['tipo_solicitud' => 'Salas de cómputo-configuración de software', 'categoria_servicio_id' => 15],
            ['tipo_solicitud' => 'Salas de cómputo-instalación de software', 'categoria_servicio_id' => 15],
            ['tipo_solicitud' => 'Salas de cómputo-mantenimiento a hardware', 'categoria_servicio_id' => 15],
            ['tipo_solicitud' => 'Salas de cómputo-préstamo para actvidades extrahorario', 'categoria_servicio_id' => 15],
            ['tipo_solicitud' => 'Salas de cómputo-proporcionar horarios', 'categoria_servicio_id' => 15],
            ['tipo_solicitud' => 'Salas de cómputo-revisión de hardware', 'categoria_servicio_id' => 15],
            ['tipo_solicitud' => 'Salas de cómputo-revisión de internet', 'categoria_servicio_id' => 15],
            ['tipo_solicitud' => 'Salas de cómputo-revisión de mobiliario', 'categoria_servicio_id' => 15],
            ['tipo_solicitud' => 'Seguimiento de proveedor', 'categoria_servicio_id' => 13],
            ['tipo_solicitud' => 'Sistemas-asesoría', 'categoria_servicio_id' => 17],
            ['tipo_solicitud' => 'Sistemas-incidencias', 'categoria_servicio_id' => 17],
            ['tipo_solicitud' => 'Sistemas-asignar permisos', 'categoria_servicio_id' => 17],
            ['tipo_solicitud' => 'Sistemas-calendarizar actividad', 'categoria_servicio_id' => 17],
            ['tipo_solicitud' => 'Sistemas-revisar usuario o contraseña de usuario', 'categoria_servicio_id' => 17],
            ['tipo_solicitud' => 'Software-activar o actualizar', 'categoria_servicio_id' => 18],
            ['tipo_solicitud' => 'Software-configurar', 'categoria_servicio_id' => 18],
            ['tipo_solicitud' => 'Software-instalar', 'categoria_servicio_id' => 18],
            ['tipo_solicitud' => 'Tintas-entregar o recoger', 'categoria_servicio_id' => 7],
            ['tipo_solicitud' => 'Wifi-configurar', 'categoria_servicio_id' => 14],
            ['tipo_solicitud' => 'Wifi-proporcionar clave', 'categoria_servicio_id' => 14],
        ]);
    }
}
