<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
            ['nombre' => 'Adriana' , 'apellido_paterno' => 'García', 'apellido_materno' => 'Medina', 'area_id' => 10, 'status' => true],
            ['nombre' => 'Adriana' , 'apellido_paterno' => 'Gibón', 'apellido_materno' => 'Saavedra', 'area_id' => 44, 'status' => true],
            ['nombre' => 'Alain' , 'apellido_paterno' => 'Galicia', 'apellido_materno' => 'Pimentel', 'area_id' => 38, 'status' => true],
            ['nombre' => 'Alberto' , 'apellido_paterno' => 'Meneses', 'apellido_materno' => 'Ramos', 'area_id' => 20, 'status' => true],
            ['nombre' => 'Alejandro' , 'apellido_paterno' => 'Álvarez', 'apellido_materno' => 'Hernández', 'area_id' => 46, 'status' => true],
            ['nombre' => 'Alejandra' , 'apellido_paterno' => 'Nieto', 'apellido_materno' => 'Moreno', 'area_id' => 13, 'status' => true],
            ['nombre' => 'Alumno' , 'apellido_paterno' => ' ', 'apellido_materno' => ' ', 'area_id' => 25, 'status' => true],
            ['nombre' => 'Ana María' , 'apellido_paterno' => 'Ferreyra', 'apellido_materno' => 'Canales', 'area_id' => 21, 'status' => true],
            ['nombre' => 'Angel Rodrigo' , 'apellido_paterno' => 'Córdoba', 'apellido_materno' => 'Ruíz', 'area_id' => 30, 'status' => true],
            ['nombre' => 'Aracely' , 'apellido_paterno' => 'Martínez', 'apellido_materno' => 'Albarrán', 'area_id' => 7, 'status' => true],
            ['nombre' => 'Aurora' , 'apellido_paterno' => 'Delgado', 'apellido_materno' => 'Esquivel', 'area_id' => 37, 'status' => true],
            ['nombre' => 'Becario' , 'apellido_paterno' => ' ', 'apellido_materno' => ' ', 'area_id' => 29, 'status' => true],
            ['nombre' => 'Carlos' , 'apellido_paterno' => 'Contreras', 'apellido_materno' => 'Miranda', 'area_id' => 24, 'status' => true],
            ['nombre' => 'Carolina' , 'apellido_paterno' => 'Cano', 'apellido_materno' => 'Hernández', 'area_id' => 27, 'status' => true],
            ['nombre' => 'Dafne Monserrat' , 'apellido_paterno' => 'Cortés', 'apellido_materno' => 'Morales', 'area_id' => 13, 'status' => true],
            ['nombre' => 'David' , 'apellido_paterno' => 'López', 'apellido_materno' => 'Galicia', 'area_id' => 35, 'status' => true],
            ['nombre' => 'Diana Marlen' , 'apellido_paterno' => 'Carmona', 'apellido_materno' => 'Jacinto', 'area_id' => 10, 'status' => true],
            ['nombre' => 'Dulce Janeth' , 'apellido_paterno' => 'Colín', 'apellido_materno' => 'Bárcenas', 'area_id' => 8, 'status' => true],
            ['nombre' => 'Edith' , 'apellido_paterno' => 'Díaz', 'apellido_materno' => 'Rosas', 'area_id' => 17, 'status' => true],
            ['nombre' => 'Efraín' , 'apellido_paterno' => 'García', 'apellido_materno' => 'Vázquez', 'area_id' => 40, 'status' => true],
            ['nombre' => 'Elizabeth' , 'apellido_paterno' => 'Cancino', 'apellido_materno' => 'Herrera', 'area_id' => 14, 'status' => true],
            ['nombre' => 'Elizabeth' , 'apellido_paterno' => 'Melitón', 'apellido_materno' => 'Ortíz', 'area_id' => 22, 'status' => true],
            ['nombre' => 'Erandeni' , 'apellido_paterno' => 'González', 'apellido_materno' => 'Arellano', 'area_id' => 14, 'status' => true],
            ['nombre' => 'Erika' , 'apellido_paterno' => 'Laredo', 'apellido_materno' => 'Martínez', 'area_id' => 4, 'status' => true],
            ['nombre' => 'Eugenia' , 'apellido_paterno' => 'Sánchez', 'apellido_materno' => 'Delgadillo', 'area_id' => 25, 'status' => true],
            ['nombre' => 'Felicitas' , 'apellido_paterno' => 'Torres', 'apellido_materno' => 'López', 'area_id' => 30, 'status' => true],
            ['nombre' => 'Flor de María' , 'apellido_paterno' => 'González', 'apellido_materno' => 'Esquivel', 'area_id' => 38, 'status' => true],
            ['nombre' => 'Gabriel' , 'apellido_paterno' => 'García', 'apellido_materno' => 'Pimentel', 'area_id' => 34, 'status' => true],
            ['nombre' => 'Gloria' , 'apellido_paterno' => 'Cruz', 'apellido_materno' => 'González', 'area_id' => 25, 'status' => true],
            ['nombre' => 'Guadalupe' , 'apellido_paterno' => 'Bernal', 'apellido_materno' => 'Velázquez', 'area_id' => 9, 'status' => true],
            ['nombre' => 'Guadalupe' , 'apellido_paterno' => 'Hurtado', 'apellido_materno' => 'Mercado', 'area_id' => 3, 'status' => true],
            ['nombre' => 'Guenvieve' , 'apellido_paterno' => 'Fournier', 'apellido_materno' => 'Llerandi', 'area_id' => 20, 'status' => true],
            ['nombre' => 'Isabel' , 'apellido_paterno' => 'Iturbe', 'apellido_materno' => 'Bello', 'area_id' => 25, 'status' => true],
            ['nombre' => 'Janeth' , 'apellido_paterno' => 'Martínez', 'apellido_materno' => 'Torres', 'area_id' => 29, 'status' => true],
            ['nombre' => 'Jazmín' , 'apellido_paterno' => 'Moran', 'apellido_materno' => 'Escobar', 'area_id' => 44, 'status' => true],
            ['nombre' => 'Jennifer' , 'apellido_paterno' => 'Becerril', 'apellido_materno' => 'Rodríguez', 'area_id' => 32, 'status' => true],
            ['nombre' => 'Jessica' , 'apellido_paterno' => 'García', 'apellido_materno' => 'Pimentel', 'area_id' => 26, 'status' => true],
            ['nombre' => 'Jesús' , 'apellido_paterno' => 'Castro', 'apellido_materno' => 'Solano', 'area_id' => 59, 'status' => true],
            ['nombre' => 'José Habraham' , 'apellido_paterno' => 'Martínez', 'apellido_materno' => 'Mendoza', 'area_id' => 23, 'status' => true],
            ['nombre' => 'Juan' , 'apellido_paterno' => 'Castañeda', 'apellido_materno' => 'Galicia', 'area_id' => 39, 'status' => true],
            ['nombre' => 'Julio Cesar' , 'apellido_paterno' => 'Banderas', 'apellido_materno' => 'Jiménez', 'area_id' => 44, 'status' => true],
            ['nombre' => 'Julio' , 'apellido_paterno' => 'Colín', 'apellido_materno' => 'Ángel', 'area_id' => 54, 'status' => true],
            ['nombre' => 'Laura' , 'apellido_paterno' => 'García', 'apellido_materno' => 'Escalona', 'area_id' => 27, 'status' => true],
            ['nombre' => 'Lizbeth' , 'apellido_paterno' => 'Fontes', 'apellido_materno' => 'Domínguez', 'area_id' => 22, 'status' => true],
            ['nombre' => 'Lourdes' , 'apellido_paterno' => 'Barrios', 'apellido_materno' => 'Cruz', 'area_id' => 30, 'status' => true],
            ['nombre' => 'María de la Luz A.' , 'apellido_paterno' => 'García', 'apellido_materno' => 'García', 'area_id' => 37, 'status' => true],
            ['nombre' => 'Maestro(a)' , 'apellido_paterno' => ' ', 'apellido_materno' => ' ', 'area_id' => 27, 'status' => true],
            ['nombre' => 'Manolo' , 'apellido_paterno' => 'Trujillo', 'apellido_materno' => 'Arriola', 'area_id' => 20, 'status' => true],
            ['nombre' => 'Maria Eugenia' , 'apellido_paterno' => 'Pérez', 'apellido_materno' => 'Mejía', 'area_id' => 19, 'status' => true],
            ['nombre' => 'Maria Fernanda' , 'apellido_paterno' => 'López', 'apellido_materno' => 'Cruz', 'area_id' => 25, 'status' => true],
            ['nombre' => 'Maritza Guadalupe' , 'apellido_paterno' => 'Reyes', 'apellido_materno' => 'Gómez', 'area_id' => 57, 'status' => true],
            ['nombre' => 'Mauro' , 'apellido_paterno' => 'García', 'apellido_materno' => 'Flores', 'area_id' => 59, 'status' => true],
            ['nombre' => 'Merced' , 'apellido_paterno' => 'Ortega', 'apellido_materno' => 'Salazar', 'area_id' => 23, 'status' => true],
            ['nombre' => 'Miroslava' , 'apellido_paterno' => 'Castañeda', 'apellido_materno' => 'Salinas', 'area_id' => 48, 'status' => true],
            ['nombre' => 'Myrna Emireth' , 'apellido_paterno' => 'Galicia', 'apellido_materno' => 'Pimentel', 'area_id' => 55, 'status' => true],
            ['nombre' => 'Mónica Fernanda' , 'apellido_paterno' => 'Núñez', 'apellido_materno' => 'Zárate', 'area_id' => 5, 'status' => true],
            ['nombre' => 'Noemí' , 'apellido_paterno' => 'Escobar', 'apellido_materno' => 'García', 'area_id' => 25, 'status' => true],
            ['nombre' => 'Nora' , 'apellido_paterno' => 'Pimentel', 'apellido_materno' => 'Pichardo', 'area_id' => 32, 'status' => true],
            ['nombre' => 'Oscar' , 'apellido_paterno' => 'Castañeda', 'apellido_materno' => 'Carbajal', 'area_id' => 50, 'status' => true],
            ['nombre' => 'Paloma de Belem' , 'apellido_paterno' => 'Lezama', 'apellido_materno' => 'Moreno', 'area_id' => 14, 'status' => true],
            ['nombre' => 'Paulina' , 'apellido_paterno' => 'Hinojosa', 'apellido_materno' => 'Torres', 'area_id' => 30, 'status' => true],
            ['nombre' => 'Alejandra' , 'apellido_paterno' => 'Patricia', 'apellido_materno' => 'Barrera', 'area_id' => 21, 'status' => true],
            ['nombre' => 'Proveedor' , 'apellido_paterno' => ' ', 'apellido_materno' => ' ', 'area_id' => 51, 'status' => true],
            ['nombre' => 'Raúl' , 'apellido_paterno' => 'Guzmán', 'apellido_materno' => 'Macedo', 'area_id' => 48, 'status' => true],
            ['nombre' => 'Reynaldo' , 'apellido_paterno' => 'Cabrera', 'apellido_materno' => 'Rebollo', 'area_id' => 15, 'status' => true],
            ['nombre' => 'Ricardo Sahid' , 'apellido_paterno' => 'Guzmán', 'apellido_materno' => 'Macedo', 'area_id' => 8, 'status' => true],
            ['nombre' => 'Rocío' , 'apellido_paterno' => 'Bibiano', 'apellido_materno' => 'Cienfuegos', 'area_id' => 54, 'status' => true],
            ['nombre' => 'Rocío' , 'apellido_paterno' => 'Martínez', 'apellido_materno' => 'Vilchis', 'area_id' => 58, 'status' => true],
            ['nombre' => 'Samuel' , 'apellido_paterno' => 'Galán', 'apellido_materno' => 'Jaimes', 'area_id' => 50, 'status' => true],
            ['nombre' => 'Sandra' , 'apellido_paterno' => 'Casares', 'apellido_materno' => 'Gómeztagle', 'area_id' => 41, 'status' => true],
            ['nombre' => 'Scherezada' , 'apellido_paterno' => 'Zuñiga', 'apellido_materno' => 'Ordoñez', 'area_id' => 13, 'status' => true],
            ['nombre' => 'Sergio' , 'apellido_paterno' => 'Ruiz', 'apellido_materno' => 'Reyes', 'area_id' => 31, 'status' => true],
            ['nombre' => 'Servicio' , 'apellido_paterno' => 'Social', 'apellido_materno' => ' ', 'area_id' => 29, 'status' => true],
            ['nombre' => 'Silvia' , 'apellido_paterno' => 'Núñez', 'apellido_materno' => 'Pérez', 'area_id' => 33, 'status' => true],
            ['nombre' => 'Soledad' , 'apellido_paterno' => 'Sánchez', 'apellido_materno' => 'Sánchez', 'area_id' => 36, 'status' => true],
            ['nombre' => 'Ricardo' , 'apellido_paterno' => ' ', 'apellido_materno' => ' ', 'area_id' => 59, 'status' => true],
            ['nombre' => 'Susana' , 'apellido_paterno' => 'Ruiz', 'apellido_materno' => 'Reyes', 'area_id' => 34, 'status' => true],
            ['nombre' => 'Tomás Marcos' , 'apellido_paterno' => 'Alcántara', 'apellido_materno' => 'Granda', 'area_id' => 32, 'status' => true],
            ['nombre' => 'Uriel' , 'apellido_paterno' => 'Galicia', 'apellido_materno' => 'Pimentel', 'area_id' => 29, 'status' => true],
            ['nombre' => 'Verónica' , 'apellido_paterno' => 'Juárez', 'apellido_materno' => 'Ortíz', 'area_id' => 12, 'status' => true],
            ['nombre' => 'Vigilancia' , 'apellido_paterno' => ' ', 'apellido_materno' => ' ', 'area_id' => 59, 'status' => true],
            ['nombre' => 'Viridiana' , 'apellido_paterno' => 'Herrera', 'apellido_materno' => 'Vidal', 'area_id' => 39, 'status' => true],
            ['nombre' => 'Zureyma Yveth' , 'apellido_paterno' => 'Gómez', 'apellido_materno' => 'Hernández', 'area_id' => 17, 'status' => true],
        ]);
    }
}
