<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Image;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 20; $i++) {
            Image::factory()->for(Brand::factory(), 'imageable')->create();
        }
    }
}
