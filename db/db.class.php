<?php

class DBConnection {
	private static $instance;
	private $dsn;
	private static $db_name;
	
	public function __construct() {}
	
	private function __clone() {}
	
	public static function getInstance($db_name) {
		if (!self::$instance || $db_name != self::$db_name) {
			$dsn = "mysql:host=localhost;dbname=$db_name";
			$options = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			); 
			
			try {
				self::$instance = new PDO($dsn, 'offcamp1_uche', 'djradioactive2015', $options);
				self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo $e->getMessage();
				exit;
			}
		}
		return self::$instance;
	}
}


class db extends DBConnection {
	
	public function __construct($db_name) {
		$this->dbh = DBConnection::getInstance($db_name);
	}
	
	
	/**
	 * All queries are prepared!
	 * 
	 * Parameters -
	 * 	@$sql - The SQL query
	 * 	@$param - Associative array, the associative index must bear the same name(s) as the placeholder(s)
	 * 	and their positions must correspond with their placeholder position in the query
	 */
	public function query($sql, $param=null)
	{
		$this->stmt = $this->dbh->prepare($sql);
		
		try {
			$this->stmt->execute($param);
			return $this->stmt; 	// Return PDO result statment
		} catch (PDOException $e) {
			echo "Something bad happened - " . $e->getMessage();
			return false;
		}
	}
	
	
	function fetch($mode=null)
	{
		if ($mode == 'obj')
			return $this->stmt->fetch(PDO::FETCH_OBJ);
		else
			return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	
	function fetchAll()
	{
		return $this->stmt->fetchAll();
	}
	
	
	function escapeString($val)
	{
		if (!$this->dbh) {
			return null;
		}
		return $this->dbh->quote($val);
	}
	
	
	function getLastInsertId()
	{
		if (!$this->dbh) {
			return null;
		}
		return $this->dbh->lastInsertId();
	}
	
	
	function beginDbTransaction()
	{
		if (!$this->dbh) {
			return null;
		}
		$this->dbh->beginTransaction();
	}
	
	function commitTransaction()
	{
		if (!$this->dbh) {
			return null;
		}
		$this->dbh->commit();
	}
	
	function rollBackTransaction()
	{
		if (!$this->dbh) {
			return null;
		}
		$this->dbh->rollBack();
	}
}

?>