<?php


namespace App;

use stdClass;

abstract class Model
{
	protected $table;
	private $model;
	private $database;
	private static $instance;
	
	public function __construct(\stdClass $model) {
		$this->model = $model;
	}
	
	public function __get( $name )
	{
		if (isset($this->model->$name)) {
			return $this->model->$name;
		}
		return null;
	}
	
	public function __set( $name, $value ) : void
	{
		if(!$this->model){
			$this->model = new stdClass();
		}
		
		if(!isset($this->model->password) && $name !== "password"){
			$this->model->$name = $value;
		}
	}
	
	public static function instance() : self{
		if(!self::$instance){
			self::$instance = new static(new \stdClass());
		}
		return self::$instance;
	}
	
	public static function find(int $id) : self{
		return new static(
			Database::table(self::instance()->table)
				->where(["id"=>$id])
				->first()
		);
	}
	
	public static function where(array $args) : self{
		self::instance()->database = Database::table(self::instance()->table)->where($args);
		return self::instance();
	}
	
	public function get() : ?array{
		return $this->manyModels($this->database->get(), $this);
	}
	
	public static function all() : ?array{
		return self::where([[ "id", ">=", 1 ]])->get();
	}
	
	public function first() : ?self{
		$model = $this->database->first();
		if($model){
			return new $this($model);
		}
		return null;
	}
	
	public function save()
	{
		if (isset($this->model->id)) {
			return Database::table($this->table)->update(json_decode(json_encode($this->model), true))->where([ "id" => $this->model->id ])->execute();
		}
		
		return Database::table($this->table)->insert(json_decode(json_encode($this->model), true));
	}
	
	public function belongsTo($belongsClass, $selfCol){
		$belongsClassTable = get_class_vars($belongsClass)[ 'table' ];
		return new $belongsClass(Database::table($belongsClassTable)->where(["id" => $this->$selfCol])->first());
	}
	
	public function hasMany($hasClass, $hasCol){
		$hasClassTable = get_class_vars($hasClass)[ 'table' ];
		return $this->manyModels(Database::table($hasClassTable)->where([$hasCol => $this->model->id])->get(), $hasClass);
	}
	
	private function manyModels(array $object, $class) : ?array{
		foreach($object as $model){
			$models[] = new $class($model);
		}
		
		if(!empty($models)){
			return $models;
		} else {
			return null;
		}
	}
}