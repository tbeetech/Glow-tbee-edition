<?php

namespace App\Support;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;
use Throwable;

class CloudinaryUploader
{
    public static function uploadImage($file, string $folder): string
    {
        if (!$file) {
            return '';
        }

        if (!self::hasCloudinaryConfig()) {
            return self::storeLocally($file, $folder);
        }

        try {
            $path = Cloudinary::upload($file->getRealPath(), [
                'folder' => $folder,
                'resource_type' => 'image',
            ])->getSecurePath();

            if (!$path) {
                return self::storeLocally($file, $folder);
            }

            return $path;
        } catch (Throwable $exception) {
            return self::storeLocally($file, $folder);
        }
    }

    private static function hasCloudinaryConfig(): bool
    {
        return (bool) config('services.cloudinary.url')
            || (config('services.cloudinary.cloud_name')
                && config('services.cloudinary.key')
                && config('services.cloudinary.secret'));
    }

    private static function storeLocally($file, string $folder): string
    {
        $cleanFolder = trim($folder, '/');
        $path = $file->store('uploads/' . $cleanFolder, 'public');

        return Storage::url($path);
    }
}
