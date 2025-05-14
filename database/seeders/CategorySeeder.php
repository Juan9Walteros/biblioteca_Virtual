<?php
 
namespace Database\Seeders;
 
use App\Models\Category;
use Illuminate\Database\Seeder;
 
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = [
            'Tecnología',
            'Negocios',
            'Diseño Gráfico',
            'Autoayuda',
            'Arte',
            'Marketing',
            'Ciencia',
            'Educación',
            'Salud',
            'Lenguas',
            'Programación',
            'Economía',
            'Gastronomía',
            'Viajes',
            'Moda',
            'Música',
            'Cine',
            'Deportes',
            'Ecología',
            'Historia',
            'Literatura Universal',
            'Fotografía',
            'Matemáticas',
            'Psicología',
            'Religión y Espiritualidad',
            'Ingeniería y Robótica',
            'Derecho',
            'Ciencia Ficción',
            'Tecnología y Automatización'
        ];
 
        foreach ($category as $categories) {
            Category::create([
                'name' => $categories
            ]);
        }
    }
}