<?php
namespace App\Repositories\Size;

use App\Repositories\RepositoryInterface;

interface SizeRepositoryInterface extends RepositoryInterface
{
    public function getSize($size);
}
