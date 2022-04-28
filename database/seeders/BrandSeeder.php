<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
            $name = time() . '-brand-' . Str::slug(Str::random(20)) . ".png";
            Image::factory()->for(Brand::factory(), 'imageable')->create([
                'name' => $name,
            ]);
            if(!Storage::exists('brands')){
                Storage::makeDirectory('brands');
            }
            Storage::put('brands/' . $name, '');
        }
    }
}
