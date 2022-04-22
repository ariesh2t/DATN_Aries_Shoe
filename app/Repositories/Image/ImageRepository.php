<?php
namespace App\Repositories\Image;

use App\Models\Image;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Image::class;
    }
    
    public function deleteFileImage($file)
    {
        if (File::exists($file)) {
            File::delete($file);
            return true;
        } else {
            return false;
        }
    }
}
