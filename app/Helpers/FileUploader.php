<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Log;

class FileUploader
{
    public static function uploadFile($file, string $path = "images", string $initials = "img"): string
    {
        try {
            $destinationPath =  $path;
            $req_file = $initials . '-' . rand(1, 1000) . sha1(time()) . "." . $file->getClientOriginalExtension();
            $file = $file->move($destinationPath, $req_file);
            return  str_replace('\\', '/', $file);
        } catch (Exception  $e) {
            Log::info('Exception in image upload : ' . $e->getMessage());
            throw new Exception("Failed to upload image. error : " . $e->getMessage());
        }
    }
}
