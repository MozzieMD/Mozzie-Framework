<?php


namespace App\Models;


use App\Model;

class User extends Model
{
	protected $table = "users";
	
	public function posts()
	{
		return $this->hasMany("App\Models\Post", "user_id");
	}
}