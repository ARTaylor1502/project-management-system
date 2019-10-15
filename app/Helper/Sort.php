<?php

namespace App\Helper;

class Sort {
    public function removePrecedingArrayElements($array, $element) {
        $index = array_search($element, $array);

        for($i = 0; $i < $index + 1; $i++) {
            unset($array[$i]);
        }

        return $array;
    }
}