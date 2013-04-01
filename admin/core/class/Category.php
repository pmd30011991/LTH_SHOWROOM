<?php 
require_once('Database.php');
	class Category{
		
		private $db;
		function __construct(){
			$this->db = Database::getInstance();
		}
		function insert($args){
			return $this->db->insert('category', $args);
		}
        function updateCategoryById($id,$args){
            return $this->db->update('category', $args,'id='.$id);
        }	
        function getCategoryById($id){
            return $this->db->select('category','id='.$id);
        }
        function delete($id){
             return $this->db->delete('category',"id=".$id);
        }
        function getAll(){
             return $this->db->select('category');
        }
        function getFeatureById($id) {
            return $this->db->select('product',"feature='1' and category_id=".$id);
        }
	}
?>