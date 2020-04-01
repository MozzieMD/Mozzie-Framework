<?php


namespace App\Controllers\Auth;


use App\Auth;
use App\Database;
use App\Models\User;
use App\Request;
use App\Router;
use App\Session;
use App\Validator;

class AuthController
{
	public function login(Request $request){
		$validator = new Validator([
			$request->post["email"] => "email",
			$request->post["password"] => "password"
		]);
		
		if(!$validator->validate()){
			Session::flash("errors", $validator->errors);
			return Router::back();
		}
		
		$user = User::where(["email" => $request->post["email"]])->first();
		
		if($user && password_verify($request->post["password"], $user->password)){
			Auth::login($user);
			return Router::redirect(Router::url("home"));
		}
		
		Session::flash("errors", ["auth" => "Authentication failed!"]);
		return Router::back();

	}
	
	public function register(Request $request){
		$validator = new Validator([
			$request->post["name"] => "name",
			$request->post["email"] => "email",
			$request->post["password"] => "password"
		]);
		
		if(!$validator->validate()){
			Session::flash("errors", $validator->errors);
			return Router::back();
		}
		
		$repeat = User::where(["email" => $request->post["email"]])->first();
		
		if(!$repeat){
			$user = new User([
				"email" => $request->post["email"],
				"name" => $request->post["name"],
				"password" => password_hash($request->post["password"], PASSWORD_DEFAULT)
			]);
			$user->save();
			$user = User::find(Database::lastId());
			Auth::login($user);
			Router::redirect("/");
			
		} else {
			Session::flash("errors", ["email" => "Email already taken."]);
			return Router::back();
		}
	}
	
	public function logout(){
		Auth::logout();
		return Router::back();
	}
}