<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    private $name;
    private $lat;
    private $lon;

    public function __construct($name, $lat, $lon) {
        $this->name = $name;
        $this->lat = $lat;
        $this->lon = $lon;
    }
}
