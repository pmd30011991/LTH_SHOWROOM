<?php 
require_once('Database.php');
	class Product{
		
		private $db;
		function __construct(){
			$this->db = Database::getInstance();
		}
		function insert($args){
			return $this->db->insert('product', $args);
		}
        function updateCategoryById($id,$args){
            return $this->db->update('product', $args,'id='.$id);
        }	
        function getCategoryById($id){
            return $this->db->select('product','id='.$id);
        }
        function delete($id){
             return $this->db->delete('product',"id=".$id);
        }
        function getAll(){
             return $this->db->select('product');
        }
	}
?>