<?php

namespace App\Helper;

class Storage
{
    public static function createItemDirectoryString($item_id) {
        $directory=str_split($item_id);
        $directory_string=implode('/', $directory);

        return $directory_string;
    }

    public static function getItemDirectory($item_id) {
        $directory=str_split($item_id);
        $directory_string=implode('/', $directory);

        return $directory_string;
    }
}
