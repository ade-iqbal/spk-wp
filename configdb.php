<?php

// constant data
$title = 'SPK WP Pemilihan Cafe Terbaik - Universitas Andalas';

class Connection {

	private $connection;

	public function __construct(){
		$this->connection = new mysqli("localhost", "root", "", "spk_wp");    

		if($this->connection->connect_errno > 0) {
			echo $this->connection->connect_errno." - ".$this->connection->connect_error;
		}
	}

	public function getConnection(){
		return $this->connection;
	}

}
