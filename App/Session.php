<?php


namespace App;


class Session
{

	public static function add($key, $value){
		$_SESSION[$key] = $value;
	}
	
	public static function remove($key){
		unset($_SESSION[$key]);
	}
	
	public static function get($key){
		if(self::exists($key))
			return $_SESSION[$key];
	}
	
	public static function flash($key, $value){
		if(!isset(self::get("flashed")[$key])) {
			self::add($key, $value);
			$_SESSION["flashed"][$key] = 1;
		}

	}
	
	public static function unFlash(){
		if(self::get("flashed")){
			foreach(self::get("flashed") as $key => $value){
				if($value === 0) {
					self::remove($key);
					unset($_SESSION["flashed"][$key]);
				}
				else {
					$_SESSION["flashed"][$key] = 0;
				}
			}
		}
	}
	
	public static function exists($key){
		return isset($_SESSION[$key]) ? true : false;
	}
	
}