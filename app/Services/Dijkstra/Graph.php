<?php

namespace App\Services\Dijkstra;
/*
 * https://github.com/DonVictor/PHP-Dijkstra/blob/master/PriorityQueue.php
 * Author: doug@neverfear.org
 */

use App\Services\Dijkstra\Edge;
require_once("PriorityQueue.php");

class Graph {

	public $nodes = array();

	public function addedge($start, $end, $weight = 0) {
		if (!isset($this->nodes[$start])) {
			$this->nodes[$start] = array();
		}
		array_push($this->nodes[$start], new Edge($start, $end, $weight));
	}

    public function removenode($index) {
		array_splice($this->nodes, $index, 1);
	}


	public function paths_from($from) {
		$dist = array();
		$dist[$from] = 0;

		$visited = array();

		$previous = array();

		$queue = array();
		$Q = new PriorityQueue();
		$Q->add(array($dist[$from], $from));

		$nodes = $this->nodes;

		while($Q->size() > 0) {
			list($distance, $u) = $Q->remove();

			if (isset($visited[$u])) {
				continue;
			}
			$visited[$u] = True;

			if (!isset($nodes[$u])) {
				print "WARNING: '$u' is not found in the node list\n";
			}

			foreach($nodes[$u] as $edge) {

				$alt = $dist[$u] + $edge->weight;
				$end = $edge->end;
				if (!isset($dist[$end]) || $alt < $dist[$end]) {
					$previous[$end] = $u;
					$dist[$end] = $alt;
					$Q->add(array($dist[$end], $end));
				}
			}
		}
		return array($dist, $previous);
	}

	public function paths_to($node_dsts, $tonode) {
		// unwind the previous nodes for the specific destination node

		$current = $tonode;
		$path = array();

		if (isset($node_dsts[$current])) { // only add if there is a path to node
			array_push($path, $tonode);
		}
		while(isset($node_dsts[$current])) {
			$nextnode = $node_dsts[$current];

			array_push($path, $nextnode);

			$current = $nextnode;
		}

		return array_reverse($path);

	}

	public function getpath($from, $to) {
		list($distances, $prev) = $this->paths_from($from);
		return $this->paths_to($prev, $to);
	}

}
