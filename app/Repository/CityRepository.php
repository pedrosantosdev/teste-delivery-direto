<?php

namespace App\Repository;

class CityRepository
{
    private $citys;
    protected $file =  "cidades.txt";

    public function __construct() {
        // load database file cidades
        $file = fopen(database_path($this->file), 'r');
        $array = array();
        while ($value = fgets($file)) {
            $city = trim($value);
            $v = explode(',', $city);
            array_push($array, $v);
        }
        fclose($file);
        $this->citys = $array;
    }

    public function all(){
        return $this->citys;
    }

    // locate city by name
    public function getByName($name){
        return array_filter($this->citys, function ($k, $v) use ($name) {
            return strpos($k[0], $name) > -1;
        }, ARRAY_FILTER_USE_BOTH);
    }

    public function save($array){
        $text = join(',',$array) . PHP_EOL;
        file_put_contents(database_path($this->file), $text, FILE_APPEND);
    }
}
