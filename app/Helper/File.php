<?php

namespace App\Helper;

use Illuminate\Support\Facades\Storage;

class File
{
    public function nestArray($array, $dir) {
        $initial_array = $array;

        $main_array = array();
        $array_index = 0;

        while(count($array) > 0) {
            $dir_name = array_shift($array);
            $sub_array = array_slice($initial_array, $array_index);
            $dir_path = $dir . '/' . implode('/', $sub_array);

            $files = Storage::files($dir_path);

            foreach($files as &$file) {
                $file_array = explode('/', $file);
                $file_name = end($file_array);
                $file_ext_array = explode('.', $file_name);
                $file_ext = end($file_ext_array);

                $file = array(
                    'name'              =>  $file_name,
                    'path'              =>  Storage::url($file),
                    'file_ext'          =>  $file_ext,
                    'last_modified'     =>  date('d/m/Y', Storage::lastModified($file))
                );
            }

            $main_array = array(
                'name'      =>  $dir_name,
                'type'      =>  'folder',
                'files'     =>  $files,
                'children'  =>  array()
            );
        }


        return $main_array;

    }
}