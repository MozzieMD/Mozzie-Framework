<?php


namespace App;


class Middleware
{
	public function auth(){
		if(Auth::check()){
			return true;
		}
		return false;
	}
	
	public function guest(){
		if(Auth::check()){
			return false;
		}
		return true;
	}
	
	public function admin(){
		if((int)Auth::user()->id === 1){
			return true;
		}
		return false;
	}
}