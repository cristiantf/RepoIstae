<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comunidad;
use App\Models\Coleccion;
use Illuminate\Support\Str;

class ComunidadColeccionSeeder extends Seeder
{
    public function run(): void
    {
        $comunidades = [
            [
                'nombre' => 'Trabajos de Titulación',
                'descripcion' => 'Tesis, monografías y proyectos de grado de los estudiantes del ISTAE.',
                'orden' => 1,
                'colecciones' => [
                    'Tecnología en Desarrollo de Software',
                    'Tecnología en Mecatrónica',
                    'Tecnología en Electrónica',
                    'Tecnología en Administración',
                    'Tecnología en Contabilidad'
                ]
            ],
            [
                'nombre' => 'Artículos Científicos',
                'descripcion' => 'Publicaciones académicas e investigaciones en revistas indexadas.',
                'orden' => 2,
                'colecciones' => [
                    'Publicados por Docentes',
                    'Publicados por Estudiantes'
                ]
            ],
            [
                'nombre' => 'Proyectos de Investigación',
                'descripcion' => 'Informes finales de proyectos de investigación formativa y aplicada.',
                'orden' => 3,
                'colecciones' => [
                    'Proyectos Semestrales',
                    'Proyectos de Vinculación'
                ]
            ],
            [
                'nombre' => 'Documentos Institucionales',
                'descripcion' => 'Manuales, reglamentos y guías oficiales del instituto.',
                'orden' => 4,
                'colecciones' => [
                    'Reglamentos y Estatutos',
                    'Manuales Académicos'
                ]
            ]
        ];

        foreach ($comunidades as $comData) {
            $comunidad = Comunidad::firstOrCreate(
                ['nombre' => $comData['nombre']],
                [
                    'descripcion' => $comData['descripcion'],
                    'slug' => Str::slug($comData['nombre']),
                    'orden' => $comData['orden'],
                    'activo' => 1
                ]
            );

            foreach ($comData['colecciones'] as $colName) {
                Coleccion::firstOrCreate(
                    ['comunidad_id' => $comunidad->id, 'nombre' => $colName],
                    [
                        'descripcion' => 'Documentos pertenecientes a ' . $colName,
                        'slug' => Str::slug($colName),
                        'orden' => 0,
                        'activo' => 1
                    ]
                );
            }
        }
    }
}
