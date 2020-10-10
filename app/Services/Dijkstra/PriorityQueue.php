<?php

namespace App\Services\Dijkstra;

/*
 * https://github.com/DonVictor/PHP-Dijkstra/blob/master/PriorityQueue.php
 * Author: doug@neverfear.org
 */

use App\Services\Dijkstra\PriorityList;

class PriorityQueue {

	private $size;
	private $liststart;
	private $comparator;

	function __construct($comparator) {
		$this->size = 0;
		$this->liststart = null;
		$this->listend = null;
		$this->comparator = $comparator;
	}

	function add($x) {
		$this->size = $this->size + 1;

		if($this->liststart == null) {
			$this->liststart = new PriorityList($x);
		} else {
            $node = $this->liststart;
			$comparator = $this->comparator;
			$newnode = new PriorityList($x);
			$lastnode = null;
			$added = false;
			while($node) {
				if ($comparator($newnode, $node) < 0) {
					// newnode has higher priority
					$newnode->next = $node;
					if ($lastnode == null) {
						$this->liststart = $newnode;
					} else {
						$lastnode->next = $newnode;
					}
					$added = true;
					break;
				}
				$lastnode = $node;
				$node = $node->next;
			}
			if (!$added) {
				// Lowest priority - add to the very end
				$lastnode->next = $newnode;
			}
		}
	}

	function debug() {
		$node = $this->liststart;
		$i = 0;
		if (!$node) {
			return;
		}
		while($node) {
			$node = $node->next;
			$i++;
		}
	}

	function size() {
		return $this->size;
	}

	function peak() {
		return $this->liststart->data;
	}

	function remove() {
		$x = $this->peak();
		$this->size = $this->size - 1;
		$this->liststart = $this->liststart->next;
		return $x;
    }
}
