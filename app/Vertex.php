<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vertex extends Model
{
    private $nodeA;
    private $nodeB;
    private $cost;

    public function __construct($nodeA, $nodeB, $cost) {
        $this->nodeA = $nodeA;
        $this->nodeB = $nodeB;
        $this->cost = $cost;
    }
}
