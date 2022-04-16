<?php
namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function insertDB($attributes = [])
    {
        DB::table('users')->insert([
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'email' => $attributes['email'],
            'password' => $attributes['password'],
            'status' => $attributes['status'],
            'role_id' => $attributes['role_id'],
        ]);
    }
}
