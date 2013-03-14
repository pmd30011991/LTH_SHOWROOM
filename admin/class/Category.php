<?php 
	class Category extends Database{
		
		private $db;
		function __construct(){
			$this->db = Database::getInstance();
		}
		
		
	}
?>