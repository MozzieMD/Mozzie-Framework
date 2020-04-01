<?php
namespace App;

use Closure;
use ReflectionFunction;

class Route
{
	
	public $route;
	public $controller;
	public $method;
	public $name;
	public $middleware;
	public $requestMethod;
	public $prefix;
	public $namespace = "";
	public $view;
	public static $groupMiddleware;
	public static $groupPrefix;
	public static $groupNamespace;
	
	public function __call( $name, $args )
	{
		if(Route::switchMethod($name, $args)){
			return new Route;
		}
	}
	
	public static function __callStatic($name, $args){
		$route = new self();
		
		if(Route::$groupMiddleware){
			$route->middleware = Route::$groupMiddleware;
		}
		
		if(Route::$groupPrefix){
			$route->prefix = Route::$groupPrefix;
		}
		
		if(Route::$groupNamespace){
			$route->namespace = Route::$groupNamespace;
		}
		
		if(Route::switchMethod($name, $args)){
			return new Route;
		}
		
		if($name === "view"){
			$route->route = $args[0];
			$route->view = $args[1];
			$route->requestMethod = "get";
			return $route;
		}

		if(is_string($args[1])){
			$c = explode("@", $args[1]);
			$route->controller = $c[0];
			$route->method = $c[1];
		} else {
			$route->method = $args[1];
		}
		
		$route->route = $args[0];
		$route->requestMethod = $name;
		return $route;
	}
	
	public function name($name){
		$this->name = $name;
		return $this;
	}
	
	private static function switchMethod($name, $args){
		switch($name){
			case("middleware"):
				Route::$groupMiddleware = $args[0];
				return true;
			break;
			
			case("prefix"):
				Route::$groupPrefix = $args[0];
				return true;
			break;
			
			case("namespace"):
				Route::$groupNamespace = $args[0];
				return true;
			break;
			
			case("group"):
				$args[0]();
				Route::$groupMiddleware = null;
				Route::$groupPrefix = null;
				return true;
			break;
			
			default:
				return false;
			break;
		}
	}
	
	public function __destruct()
	{
		if(is_string($this->route) && !empty($this->route))
			Router::$routes[] = $this;
	}
}