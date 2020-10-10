<?php

namespace App\Repository;

use App\Services\DistanceService;

class VertexRepository
{
    private $vertexs;
    protected $file = 'vertices.txt';

    public function __construct()
    {
        $array = array();
        // TMP file for calculate distances.
        $writing = fopen(database_path($this->file . '.tmp'), 'w');
        $replaced = false;
        // load database file vertices
        if ($file = fopen(database_path($this->file), 'r+')) {
            while (!feof($file)) {
                $read_line = fgets($file);
                $vertex = trim($read_line);
                $v = explode(',', $vertex);
                // If file with error skip
                if (count($v) == 1) { continue; }
                // Verify if the distance between two points is calculate
                // If Distance not calculate wet, calculate and update
                if (count($v) == 2) {
                    // Get Location Based on name of city
                    $pointA = (new CityRepository())->getByName($v[0]);
                    $pointB = (new CityRepository())->getByName($v[1]);
                    // If City Find Calculate
                    if (count($pointA) == 1 && count($pointB) == 1) {
                        $pointA = current($pointA);
                        $pointB = current($pointB);
                        // Calculate Distance
                        $distance = DistanceService::distance($pointA[1], $pointA[2], $pointB[1], $pointB[2]);
                        // Write line in tmp file with points and distance
                        if ($vertex == $v[0] . ',' . $v[1]) {
                            $read_line = "$v[0],$v[1],$distance" . PHP_EOL;
                            $replaced = true;
                        }
                        fputs($writing, $read_line);
                        array_push($v, $distance);
                    }
                }
                array_push($array, $v);
            }
            // Close Files
            fclose($file);
            fclose($writing);
            // Move Tmp file to Permanent
            if ($replaced) {
                rename(database_path($this->file . '.tmp'), database_path($this->file));
            } else {
                unlink(database_path($this->file . '.tmp'));
            }
        }
        $this->vertexs = $array;
    }

    public function all()
    {
        return $this->vertexs;
    }

    public function save($array)
    {
        $text = join(',', $array) . PHP_EOL;
        file_put_contents(database_path($this->file), $text, FILE_APPEND);
    }
}
