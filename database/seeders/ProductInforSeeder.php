<?php

namespace Database\Seeders;

use App\Models\ProductInfor;
use Illuminate\Database\Seeder;

class ProductInforSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductInfor::factory(30)->create();
    }
}
