<?php
namespace App;


class Auth
{
	public static function check(){
		if(Session::exists("user")){
			return true;
		}
		return false;
	}
	
	public static function login($user){
		Session::add("user", $user);
	}
	
	public static function logout(){
		if(self::check())
			Session::remove("user");
	}
	
	public static function user(){
		if(self::check())
			return Session::get("user");
		
		throw new \Exception("Not logged in, use Auth::check()");
	}
	
	public static function id(){
		if(self::check())
			Session::get("user")->id;
		
		throw new \Exception("Not logged in, use Auth::check()");
	}
	
}