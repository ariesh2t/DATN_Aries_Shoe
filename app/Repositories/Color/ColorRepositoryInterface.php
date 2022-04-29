<?php
namespace App\Repositories\Color;

use App\Repositories\RepositoryInterface;

interface ColorRepositoryInterface extends RepositoryInterface
{
    public function getColor($color);
}
