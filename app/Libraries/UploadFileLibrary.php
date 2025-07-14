<?php

namespace App\Libraries;

class UploadFileLibrary
{
    /**
     * upload image
     * @param object $file
     * @param string $pathsave
     * @param string $namefile default random name
     * @return bool|string
     */
    public static function uploadImage(object $fileGambar, string $pathsave, $namafile = null)
    {

        if ($fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $fileName = $namafile ?? $fileGambar->getRandomName();
            $fileGambar->move($pathsave, $fileName);
            return $fileName;
        }

        return false;
    }
}
