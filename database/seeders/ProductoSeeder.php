<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos =[
            ['nombre' => 'Paracetamol 500mg', 'precio' => 3.50, 'stock' => 100, 'sku' => 'MED001'],
            ['nombre' => 'Ibuprofeno 400mg', 'precio' => 4.20, 'stock' => 80, 'sku' => 'MED002'],
            ['nombre' => 'Vitamina C 1g', 'precio' => 5.00, 'stock' => 50, 'sku' => 'MED003'],
            ['nombre' => 'Alcohol en Gel 250ml', 'precio' => 2.80, 'stock' => 120, 'sku' => 'HIG001'],
            ['nombre' => 'Mascarilla KN95', 'precio' => 1.50, 'stock' => 200, 'sku' => 'HIG002'],
            ['nombre' => 'Termómetro Digital', 'precio' => 15.00, 'stock' => 30, 'sku' => 'ACC001'],
            ['nombre' => 'Tensiómetro Manual', 'precio' => 25.00, 'stock' => 20, 'sku' => 'ACC002'],
            ['nombre' => 'Jarabe para la tos', 'precio' => 6.00, 'stock' => 70, 'sku' => 'MED004'],
            ['nombre' => 'Vitamina D 5000 IU', 'precio' => 7.00, 'stock' => 40, 'sku' => 'MED005'],
            ['nombre' => 'Antiséptico Bucal', 'precio' => 3.20, 'stock' => 90, 'sku' => 'HIG003'],
        ];

        foreach($productos as $producto){
            Producto::create($producto);
        }
    }
}
