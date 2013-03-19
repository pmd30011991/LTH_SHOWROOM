<?php
/**
 * Database access class.
 * Used in applications where one point of database access is required
 *
 * Typical Usage:
 * $db = Database::getInstance();
 * $results = $db->query("SELECT * FROM test WHERE name = :name",array(":name" => "matthew"));
 * print_r($results);
 *
 * @author Matthew Elliston <matt@e-titans.com>
 * @version 1.0
 */
class Database {

	/**
	 * Instance of the database class
	 * @static Database $instance
	 */
	private static $instance;
	/**
	 * Database connection
	 * @access private
	 * @var PDO $connection
	 */
	private $connection;

	/**
	 * Constructor
	 * @param $dsn The Data Source Name. eg, "mysql:dbname=testdb;host=127.0.0.1"
	 * @param $username
	 * @param $password
	 */
	private function __construct(){
		$this->connection = new PDO("mysql:dbname=lth;host=127.0.0.1","root","");
		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * Gets an instance of the Database class
	 *
	 * @static
	 * @return Database An instance of the database singleton class.
	 */
	public static function getInstance(){
		if(empty(self::$instance)){
			try{
				self::$instance = new Database();
			} catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
			}
		}
		return self::$instance;
	}

	/**
	 * Runs a query using the current connection to the database.
	 *
	 * @param string query
	 * @param array $args An array of arguments for the sanitization such as array(":name" => "foo")
	 * @return array Containing all the remaining rows in the result set.
	 */
	public function query($query, $args){
		$tokens = explode(" ",$query);
		try{
			$sth = $this->connection->prepare($query);
			if(empty($args)){
				$sth->execute();
			}
			else{
				$sth->execute($args);
			}
			if($tokens[0] == "select"){
				$sth->setFetchMode(PDO::FETCH_ASSOC);
				$results = $sth->fetchAll();
				return $results;
			}
		} catch (PDOException $e) {
			echo 'Query failed: ' . $e->getMessage();
			echo '<br />Query : ' . $query;
		}
		return 1;
	}
	/**
	 * Returns the last inserted ID
	 *
	 * @return int ID of the last inserted row
	 */
	function insert($table,$args){
			$sql ="insert into `$table`(";
			$columns ="";
			$values ="";
			foreach($args as $k=>$v){
				$columns .='`'.$k.'`,';
				$values .="'".$v."',";
			}
			$columns = trim($columns,',');
			$values = trim($values,',');
			$sql.=$columns. ') values('.$values.')';
			return $this->query($sql,null);
	}
	function update($table,$args,$conditions){
			$sql ="update `$table` set ";
			$couples ="";
			foreach($args as $k=>$v){
				$couples .="`".$k."`='".$v."',";
			}
			$couples = trim($couples,',');
			$sql.=$couples. ' where '.$conditions;
			return $this->query($sql,null);
	}
    function select($table,$conditions = ''){
        $sql = "select * from ".$table;
        if(!empty($conditions)){
            $sql =$sql.' where '.$conditions;
        }
        return $this->query($sql,null);
    }
    function delete($table,$conditions){
        $sql ="delete from $table where ".$conditions;
        return $this->query($sql,null);
    }
	public function lastInsertId(){
		return $this->connection->lastInsertId();
	}
}
?>