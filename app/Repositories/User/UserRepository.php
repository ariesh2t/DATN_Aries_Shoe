<?php
namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use Carbon\Carbon;
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
        return DB::table('users')->insertGetId([
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'email' => $attributes['email'],
            'phone' => $attributes['phone'],
            'password' => $attributes['password'],
            'status' => $attributes['status'],
            'role_id' => $attributes['role_id'],
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
    }

    public function getUserByOrderDelivered($user_id)
    {
        return $this->model->with(['orders' => function ($query) {
            $query->where('order_status_id', config('orderstatus.delivered'));
        }])->where('id', $user_id)->first();
    }


    public function getNewUserOnWeek($start) {
        return $this->model->where('created_at', '>', $start)->count();
    }
}
