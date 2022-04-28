<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 20; $i++) {
            $name = time() . '-product-' . Str::slug(Str::random(20)) . ".png";
            Image::factory(2)->for(Product::factory(), 'imageable')->create([
                'name' => $name,
            ]);
            if(!Storage::exists('products')){
                Storage::makeDirectory('products');
            }
            Storage::put('products/' . $name, '');
        }
    }
}
