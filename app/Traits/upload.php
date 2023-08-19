<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
trait upload {
    protected $path = 'upload/users/';
    public function verify($request) {
        return $request->has('image');
    }
    public function saveImage($request)
    {
        if ($this->verify($request)) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save($this->path . $name);
            return $name;
        }
    }
    public function updateImg($request, $currentImage) {
        if($this->verify($request))
        {
            $this->deleteImage($currentImage);
            return $this->saveImage($request);
        }
        return $currentImage;
    }
    public function deleteImg($imageName) {
        if($imageName && file_exists($this->path .$imageName))
        {
            Storage::delete($this->path .$imageName);
        }
    }
}

?>
