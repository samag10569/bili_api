<?php

namespace Classes;

use Illuminate\Support\Facades\File;

class UploadImg
{
    public function uploadPic($file, $path)
    {
        $pathMain = $path . '/main/';
        $pathBig = $path . '/big/';
        $pathMedium = $path . '/medium/';

        $extension = $file->getClientOriginalExtension();
        $ext = ['jpg', 'jpeg', 'png'];
        if (in_array($extension, $ext)) {
            if (!File::isDirectory($path)) {
                File::makeDirectory($path);
            }
            if (!File::isDirectory($pathMain)) {
                File::makeDirectory($pathMain);
            }
            if (!File::isDirectory($pathBig)) {
                File::makeDirectory($pathBig);
            }
            if (!File::isDirectory($pathMedium)) {
                File::makeDirectory($pathMedium);
            }

            $fileName = md5(microtime()) . ".$extension";
            $file->move($pathMain, $fileName);
            $kaboom = explode(".", $fileName);
            $fileExt = end($kaboom);
            Resizer::resizePic($pathMain . $fileName, $pathMedium . $fileName, 400, 400, $fileExt);
            Resizer::resizePic($pathMain . $fileName, $pathBig . $fileName, 800, 800, $fileExt, True);
            return $fileName;
        } else {
            return false;
        }


    }

    public static function uploadFile($file, $path)
    {
        $extension = $file->getClientOriginalExtension();
        $ext = ['jpg', 'jpeg', 'png', 'rar', 'zip', 'pdf', 'docx', 'doc'];
        if (in_array($extension, $ext)) {
            $fileName = md5(microtime()) . ".$extension";
            $file->move($path, $fileName);
            return $fileName;
        } else {
            return false;
        }
    }

}