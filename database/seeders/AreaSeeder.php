<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;
use Illuminate\Support\Facades\DB;


class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('areas')->insert([
            ['area' => 'Aula Maker'],
            ['area' => 'Centro de Autoacceso'],
            ['area' => 'Centro de Esterilización y Equipo'],
            ['area' => 'Centro de Idiomas Franco Inglés'],
            ['area' => 'Centro de Información y Aprendizaje'],
            ['area' => 'Centro de Medios'],
            ['area' => 'Clínica 1'],
            ['area' => 'Clínica 2'],
            ['area' => 'Clínica 3'],
            ['area' => 'Clínica 4 Ortodoncia'],
            ['area' => 'Clínica 5'],
            ['area' => 'Consejo de Administración'],
            ['area' => 'Contabilidad y Egresos'],
            ['area' => 'Coordinación de Cirujano Dentista'],
            ['area' => 'Coordinación de Comunicación'],
            ['area' => 'Coordinación de Comunicación y Derecho'],
            ['area' => 'Coordinación de Derecho'],
            ['area' => 'Coordinación de Desarrollo Académico'],
            ['area' => 'Coordinación de Especialidad en Ortodoncia'],
            ['area' => 'Coordinación de Gestión Estratégica de Imagen'],
            ['area' => 'Coordinación de Idiomas'],
            ['area' => 'Coordinación de Lenguas'],
            ['area' => 'Coordinación de Maestría en Desempeño y Gestión Escolar'],
            ['area' => 'Coordinación de Negocios con Énfasis en Inglés'],
            ['area' => 'Coordinación de Preparatoria'],
            ['area' => 'Departamento de Adquisiciones'],
            ['area' => 'Departamento de Control Escolar'],
            ['area' => 'Departamento de Difusión Cultural'],
            ['area' => 'Departamento de Gestión del Talento'],
            ['area' => 'Departamento de RP y Mercadotecnia'],
            ['area' => 'Departamento de Servicios Generales'],
            ['area' => 'Departamento de Tecnologías de la Información'],
            ['area' => 'Departamento de Titulación'],
            ['area' => 'Departamento de Vinculación'],
            ['area' => 'Departamento Legal'],
            ['area' => 'Depósito Dental'],
            ['area' => 'Dirección Académica'],
            ['area' => 'Dirección Administrativa'],
            ['area' => 'Dirección Financiera'],
            ['area' => 'Diseño'],
            ['area' => 'Educación Continua'],
            ['area' => 'Enfermería'],
            ['area' => 'Externo'],
            ['area' => 'Ingresos'],
            ['area' => 'Laboratorio de Anatomía'],
            ['area' => 'Laboratorio de Biomédicas'],
            ['area' => 'Laboratorio de Ciencias'],
            ['area' => 'Nómina'],
            ['area' => 'Orientación'],
            ['area' => 'Promotoría Deportiva'],
            ['area' => 'Proveedor'],
            ['area' => 'Rayos X Clínica 2'],
            ['area' => 'Seguimiento a Egresados'],
            ['area' => 'Seguridad y Bienestar'],
            ['area' => 'Subdirección Académica'],
            ['area' => 'Supervisión de Clínicas y Laboratorios'],
            ['area' => 'Tutoría CD'],
            ['area' => 'Tutoría Licenciaturas'],
            ['area' => 'Vigilancia'],
        ]);
    }
}
