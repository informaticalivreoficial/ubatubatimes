<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            ['name' => 'Topo home 728x90', 'slug' => 'home_top', 'width' => 728, 'height' => 90],
            ['name' => 'Home Main Center 728x90', 'slug' => 'home_center', 'width' => 728, 'height' => 90],
            ['name' => 'Home Main Footer 728x90', 'slug' => 'home_footer', 'width' => 728, 'height' => 90],
            ['name' => 'Home Sidebar 300x250', 'slug' => 'home_sidebar', 'width' => 300, 'height' => 250],

            ['name' => 'Notícia Sidebar 300x250', 'slug' => 'post_sidebar', 'width' => 300, 'height' => 250],
            ['name' => 'Notícia Main Footer 728x90', 'slug' => 'post_footer', 'width' => 728, 'height' => 90],

            ['name' => 'Artigo Sidebar 300x250', 'slug' => 'article_sidebar', 'width' => 300, 'height' => 250],
            ['name' => 'Artigo Main Footer 728x90', 'slug' => 'article_footer', 'width' => 728, 'height' => 90],
            ['name' => 'Artigos Footer 728x90', 'slug' => 'articles_footer', 'width' => 728, 'height' => 90],

            ['name' => 'Boletim das Ondas Sidebar 300x250', 'slug' => 'waves_sidebar', 'width' => 300, 'height' => 250],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
