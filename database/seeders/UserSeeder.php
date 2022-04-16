<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'first_name' => 'Aries',
                'last_name' => 'Hoang',
                'phone' => '0394546187',
                'address' => 'Ha Giang, Dong Hung, Thai Binh',
                'email' => 'hathanhhoang842000@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('hoang842'),
                'status' => 1,
                'role_id' => 1,
            ]
        ]);
        User::factory(20)->create();
    }
}
