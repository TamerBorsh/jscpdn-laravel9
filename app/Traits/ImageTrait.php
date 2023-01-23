<?php
namespace App\Traits;

Trait ImageTrait
{
    public function SaveImage($photo, $folder)
    {
        $file = $photo;
        $fileName = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($folder), $fileName);

        return $fileName;
    }
}
