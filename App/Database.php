<?php

namespace App;

use PDO;

class Database
{
	private static $Instance = null;
	protected $settings = [
		"hostname" => "localhost",
		"database" => "",
		"username" => "",
		"password" => "",
	];
	private $table;
	private $connection = null;
	private $queryString = "";
	private $args = [];
	
	public static function lastId(){
		if(self::$Instance->connection){
			return self::$Instance->connection->lastInsertId();
		}
		return false;
	}
	
	public static function table( $table )
	{
		if (!self::$Instance) {
			self::$Instance = new self;
		}
		
		self::$Instance->table = $table;
		self::$Instance->clean();
		if (!self::$Instance->connection) {
			$db = self::$Instance->settings;
			$dbString = "mysql:host={$db['hostname']};dbname={$db['database']}";
			self::$Instance->connection = new PDO($dbString, $db[ 'username' ], $db[ 'password' ]);
		}
		self::$Instance->queryString = "SELECT * FROM $table";
		return self::$Instance;
	}
	
	public function clean()
	{
		$this->queryString = "";
		$this->args = [];
	}
	
	public function select( $select )
	{
		$this->queryString = "SELECT $select FROM $this->table";
		return $this;
	}
	
	public function join( $table, $join )
	{
		$this->queryString .= " INNER JOIN $table ON $join";
		return $this;
	}
	
	public function update( $args )
	{
		$this->queryString = "UPDATE $this->table SET";
		foreach ($args as $key => $value) {
			$delimiter = (array_search($key, array_keys($args)) < (count($args) - 1)) ? "," : "";
			$this->queryString .= " $key = :$key" . $delimiter;
			$this->args[ ":$key" ] = $value;
		}
		return $this;
	}
	
	public function insert( $args )
	{
		$sqlArgs = [];
		foreach ($args as $key => $value) {
			$sqlArgs[ ":" . $key ] = $value;
			$this->args[ ":" . $key ] = $value;
		}
		$this->queryString = "INSERT INTO $this->table (" . implode(', ', array_keys($args)) . ") VALUES (" . implode(', ', array_keys($sqlArgs)) . ")";
		
		
		return $this->execute();
	}
	
	public function execute()
	{
		$statement = $this->connection->prepare($this->queryString);
		return $statement->execute($this->args);
	}
	
	public function where( $where )
	{
		$loop = 1;
		if (isset($where[ 0 ]) && count($where[ 0 ]) === 3) {
			foreach ($where as $item) {
				$this->queryString .= ($loop == 1 ? " WHERE " : " AND ") . "$item[0] $item[1] :$item[0]";
				$this->args[ ":$item[0]" ] = $item[ 2 ];
				$loop++;
			}
		} else {
			foreach ($where as $key => $value) {
				$keyArg = str_replace(".", '', $key);
				$this->queryString .= ($loop == 1 ? " WHERE " : " AND ") . "$key = :$keyArg";
				$this->args[ ":$keyArg" ] = $value;
				$loop++;
			}
		}
		
		return $this;
	}
	
	public function orderBy( $by, $order = "asc" )
	{
		$this->queryString .= " ORDER BY $by $order";
		return $this;
	}
	
	public function first()
	{
		$this->queryString .= " LIMIT 1";
		
		if ($this->get())
			return $this->get()[ 0 ];
		
		return false;
	}
	
	public function get( $debug = false )
	{
		$statement = $this->connection->prepare($this->queryString);
		$statement->execute($this->args);
		//TODO: Delete for production
		if ($debug)
			dd($this->queryString);
		
		return $statement->fetchAll(PDO::FETCH_OBJ);
	}
	
	
}