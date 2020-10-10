<?php

namespace App\Services\Dijkstra;

/*
 * https://github.com/DonVictor/PHP-Dijkstra/blob/master/PriorityQueue.php
 * Author: doug@neverfear.org
 */

class PriorityList {
	public $next;
	public $data;
	function __construct($data) {
		$this->next = null;
		$this->data = $data;
	}
}
