<?php 
	class Category extends Database{
		
		private $db;
		function __construct(){
			$this->db = Database::getInstance();
		}
		function getAll(){
			return $this->db->query("select * from category");
		}
		function insert($args){
			return $this->db->insert('category', $args);
		}	
	}
?>