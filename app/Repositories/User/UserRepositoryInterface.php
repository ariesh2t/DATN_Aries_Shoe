<?php
namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function insertDB($attributes = []);

    public function getUserByOrderDelivered($user_id);

    public function getNewUserOnWeek($start);
}
