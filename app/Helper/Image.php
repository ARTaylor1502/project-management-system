<?php

namespace App\Helper;

class Image
{
    public static function findImage($path, $file_name, $extensions)
    {
        foreach($extensions as $ext)
        {
            if (file_exists($path . $file_name . '.' .$ext))
            {
                return '/' . $path . $file_name . '.' . $ext;
            }
        }

        return false;
    }
}