<?php
/**
 * Created by PhpStorm.
 * User: gewenrui
 * Date: 16/1/11
 * Time: 上午9:03
 */
require_once dirname(__DIR__) . '/DB/DB.class.php';

class migrate extends \kakoi\DB
{
    public function __construct($table)
    {

        $data = $this->serach();
        $value = require_once './Event/Config/Config.php';
        static $db;
        $db = new \kakoi\DB($value);

        $this->load($data);
    }

    //search
    public function serach()
    {
        $path = __DIR__ . '/Tables';
        $dir = opendir($path);
        global $value;
        //扫描文件夹下的数据
        while (($file = readdir($dir)) !== false) {
            if ($file != '.' && $file != '..') {

                $data = explode('.', $file);
                $value .= $data[0] . '|';
            }

        }
        return $value;

        closedir($dir);
    }

    //数据处理
    public function load($data)
    {
        $data = rtrim($data, '|');
        $data = explode('|', $data);
        foreach ($data as $value) {
            require_once __DIR__ . '/Tables/' . $value . '.class.php';
            $value = new $value();
            $data = $value->create(new Migration());
            $this->handle($data);
        }


    }


    /*public function loop($key){
        global $data;
        if(strpos($key,'|')){
            $value = explode('|',$key);

        }
    }*/
    //数据处理*2
    public function handle($data)
    {

        global $case;

        foreach ($data as $value => $key) {
            if ($value != 'table') {
                $count = substr_count($key, '|');
                if ($count > 0) {
                    $temp = explode('|', $key);
                    $key = '';
                    $length = count($temp);
                    for ($i = 0; $i < $length; $i++) {
                        $key .= $temp[$i] . '   ';
                    }

                }
                $case .= $value . '   ' . $key . ',';

            }

        }

        //去掉最后的逗号
        $case = rtrim($case, ',') . ')';
        $temp = "create table {$data->table}(";

        $sql = $temp . $case;


        $record = migrate::execute($sql);
        if ($record == false) {
            echo "{$data->table}创建失败了=";
        } else {
            echo "{$data->table}创建成功了=";
        }

        unset($case);

        // echo $sql;

    }
}