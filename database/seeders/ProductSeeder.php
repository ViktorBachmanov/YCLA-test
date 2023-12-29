<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Factories\Sequence;

use App\Models\Product;
use App\Models\Option;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = Product::factory()
            ->has(Option::factory())
            ->count(250)
            ->create();
    }
}
