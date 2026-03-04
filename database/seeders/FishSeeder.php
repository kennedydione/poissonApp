<?php

namespace Database\Seeders;

use App\Models\Fish;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fish::create([
            'name' => 'Saumon Atlantique',
            'price_per_kg' => 15.50,
            'quantity_available' => 50,
            'description' => 'Saumon frais de l\'Atlantique, riche en oméga-3.',
            'image' => 'saumon.jpg',
        ]);

        Fish::create([
            'name' => 'Thon Rouge',
            'price_per_kg' => 25.00,
            'quantity_available' => 30,
            'description' => 'Thon rouge de qualité supérieure, parfait pour les grillades.',
            'image' => 'thon.jpg',
        ]);

        Fish::create([
            'name' => 'Maquereau',
            'price_per_kg' => 8.75,
            'quantity_available' => 100,
            'description' => 'Maquereau frais, idéal pour les plats traditionnels.',
            'image' => 'maquereau.jpg',
        ]);

        Fish::create([
            'name' => 'Sole',
            'price_per_kg' => 18.90,
            'quantity_available' => 20,
            'description' => 'Sole délicate, parfaite pour les amateurs de poisson fin.',
            'image' => 'sole.jpg',
        ]);

        Fish::create([
            'name' => 'Bar',
            'price_per_kg' => 22.00,
            'quantity_available' => 15,
            'description' => 'Bar frais, savoureux et tendre.',
            'image' => 'bar.jpg',
        ]);
    }
}
