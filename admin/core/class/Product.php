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
        function updateProductById($id,$args){
            return $this->db->update('product', $args,'id='.$id);
        }	
        function getProductById($id){
            return $this->db->select('product','id='.$id);
        }
        function delete($id){
             return $this->db->delete('product',"id=".$id);
        }
        function get($limit,$page,$order_by,$order){
             return $this->db->select('product','',$limit,$page,$order_by,$order);
        }
        function getProductsByCategoryId($id,$limit,$page,$order_by,$order) {
            return $this->db->select('product','category_id='.$id,$limit,$page,$order_by,$order);
        }
        function lastId(){
            return $this->db->lastInsertId();
        }
        function count(){
             return $this->db->count('product');
        }
        function countByCategory($id){
             return $this->db->count('product','category_id='.$id);
        }
	}
?>