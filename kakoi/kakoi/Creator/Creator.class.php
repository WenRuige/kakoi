<?php

/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 16/1/11
 * Time: 上午8:20
 */
class Creator
{


    /*method*/
    public function input($input, $status)
    {
        $method = ['migrate', 'controller', 'model'];
        $input = strtolower($input);            //change xiaoxie
        if (in_array($input, $method)) {
            //  引入路径
            require_once __DIR__ . '/' . $input . '.class.php';
            return new $input($status);
        } else {
            echo "NOT FOUND 404";
        }
    }
}