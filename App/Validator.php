<?php


namespace App;


use App\Models\User;

class Validator
{
	private $valid = [
		"name" => "/^([a-zA-Z ]+)$/",
		"password" => "/^.{8,}$/"
	];
	
	private $standardErrors = [
		"email" => "E-mail is not valid.",
		"name" => "Name can contain only a-Z characters",
		"password" => "Password must be minimum 8 characters long"
	];
	
	private $data;
	public $errors;
	
	
	public function __construct($data) {
		$this->data = $data;
	}
	
	public function validate() : bool{
		foreach($this->data as $key => $value){
			if($value === "email") {
				if(!filter_var($key, FILTER_VALIDATE_EMAIL)) {
					$this->errors[ $value ] = $this->standardErrors[ $value ];
				}
			} else if(!preg_match($this->valid[$value], $key)){
				$this->errors[$value] = $this->standardErrors[$value];
			}
		}
		
		if(!empty($this->errors))
			return false;
		return true;
	}
}