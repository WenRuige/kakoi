<?php

/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 16/1/11
 * Time: 上午11:12
 */
class Migration
{
    /*
     *
     * 设置类型
     * */

    public function String($data,$digit = 10)
    {
        $this->$data = "varchar($digit)";
        return $this;
    }

    public function Int($data,$digit =10)
    {
        $this->$data = "int($digit)";
        return $this;
    }

    public function date($data)
    {
        $this->$data = 'date';
        return $this;
    }

    public function autoincrement($data)
    {
        $this->$data = $this->$data . '|primary key auto_increment';
    }

    public function index()
    {
        //return $this;
    }

    public function table($data)
    {
        $this->table = $data;
    }

}