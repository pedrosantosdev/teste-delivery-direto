<?php

namespace App\Services;

use App\Services\Dijkstra\Graph;

class DistanceService
{

    /**
     * Calculate Distance Between Two Nodes and return the distance in Kilometers
     * Based on https://www.phpninja.info/en/other/calculating-distance-two-points-latitude-and-longitude/
     */
    public static function distance($lat1, $lon1, $lat2, $lon2)
    {
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lon1 *= $pi80;
        $lat2 *= $pi80;
        $lon2 *= $pi80;
        $r = 6372.797; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;
        return $km;
    }

    public static function calcDistanceGraph($vertexs, $from, $to): array
    {
        $g = new Graph();
        foreach ($vertexs as $value) {
            // Add Edge From => To, To => From
            $g->addedge($value[0], $value[1], $value[2]);
            $g->addedge($value[1], $value[0], $value[2]);
        }
        list($distances, $prev) = $g->paths_from($from);

	    return $g->paths_to($prev, $to);
    }
}
