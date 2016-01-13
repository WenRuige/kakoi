<?php

/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 16/1/11
 * Time: 上午9:03
 */
class model
{
    //内容

    public function __construct($table)
    {
        $this->content =
        $content =
            "<?php
class $table{
      public function create(){

            }

        }";
        $path = $this->create($table);
        $this->write($path);
    }

    public function create($table)
    {

        $path = __DIR__ . '/Tables/' . $table . '.class.php';
        //创建文件
        if (!is_file($path)) {
            touch($path, 0777, true);
            return $path;
        } else {
            return $path;
        }
    }

    //写入
    public function write($path)
    {
        if (is_file($path)) {

            $myfile = fopen($path, "w") or die("Unable to open file!");
            fwrite($myfile, $this->content);
        }
    }

}