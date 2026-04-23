<?php

namespace Database\Seeders;

use App\Models\CatCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Categorias principais
        $parents = CatCompany::factory(8)->create();

        // Subcategorias
        foreach ($parents as $parent) {
            CatCompany::factory(3)->create([
                'id_pai' => $parent->id
            ]);
        }
    }
}
