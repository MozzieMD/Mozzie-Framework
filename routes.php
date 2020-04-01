<?php

use App\Auth;
use App\Models\User;
use App\Route;
use App\Router;
use App\View;


Route::namespace("Auth")->group(function(){
	
	Route::middleware("auth")->group(function(){
		
		Route::post("/logout", "AuthController@logout")->name("logout");
		
	});
	
	Route::middleware("guest")->group(function(){
		
		Route::post("/login", "AuthController@login")->name("doLogin");
		Route::view("/login", "login")->name("login");
		Route::post("/register", "AuthController@register")->name("doRegister");
		Route::view("/register", "register")->name("register");
		
	});
	
});
Route::view("/", "index")->name("home");