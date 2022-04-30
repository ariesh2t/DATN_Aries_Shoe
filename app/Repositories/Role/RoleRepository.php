<?php
namespace App\Repositories\Role;

use App\Models\Role;
use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Role::class;
    }
}
