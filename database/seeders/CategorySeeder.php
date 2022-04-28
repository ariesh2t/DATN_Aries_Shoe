<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 20; $i++) {
            $name = time() . '-category-' . Str::slug(Str::random(20)) . ".png";
            Image::factory()->for(Category::factory(), 'imageable')->create([
                'name' => $name,
            ]);
            if(!Storage::exists('categories')){
                Storage::makeDirectory('categories');
            }
            Storage::put('categories/' . $name, '');
        }
    }
}
