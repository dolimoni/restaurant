<?php

/**
 * Created by PhpStorm.
 * User: SERIALIZABLE
 * Date: 13/01/2018
 * Time: 19:40
 */
class Util
{
    public function __construct()
    {

    }

    public function array_merge_numeric_values($data){

        $merged = array();
        foreach ($data as $array) {
            foreach ($array as $key => $value) {
                if (!is_numeric($value)) {
                    continue;
                }
                if (!isset($merged[$key])) {
                    $merged[$key] = (string)$value;
                } else {
                    $merged[$key] += $value;
                    $merged[$key]= (string)$merged[$key];
                }
            }
        }
        return $merged;
    }
}