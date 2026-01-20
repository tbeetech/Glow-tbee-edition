<?php

namespace App\Support;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryUploader
{
    public static function uploadImage($file, string $folder): string
    {
        return Cloudinary::upload($file->getRealPath(), [
            'folder' => $folder,
            'resource_type' => 'image',
        ])->getSecurePath();
    }
}
