<?php


namespace App\Models;


use App\Model;

class Post extends Model
{
	protected $table = "posts";
	
	public function author(){
		return $this->belongsTo("App\Models\User", "user_id");
	}
}