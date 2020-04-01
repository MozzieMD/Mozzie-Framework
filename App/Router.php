<?php

namespace App;

class Router
{
	private $argumentsType = [
		"/{id}/" => "(\d+)",
		"/{slug}/" => "([a-z0-9]+(?:-[a-z0-9]+)*)",
	];

	public $supportedHttpMethods = [
		"GET",
		"POST"
	];
	
	private $back = false;
	public $request;
	
	public static $routes;
	
	public static $Instance;
	
	public static function instance(){
		if(self::$Instance == null)
			self::$Instance = new static(new Request());
		
		return self::$Instance;
	}
	
	public function __construct(Request $request) {
		$this->request = $request;
	}
	
	public static function back(){
		if(Session::exists("back")
			&& (Session::get("back")["uri"] !== self::instance()->request->requestUri
			 || Session::get("back")["method"] !== self::instance()->request->requestMethod)){
			
			header("Location: " . Session::get("back")["uri"]);
		} else {
			
			Header("Location: /");
		}
		
		return true;
		
	}
	
	public static function redirect($route){
		
		Header("Location: ".$route);
		return true;
		
	}
	
	private function getPattern($route){
		return "@".preg_replace(array_keys($this->argumentsType), array_values($this->argumentsType), $route->route."$@");
	}
	
	public static function url($name){
		foreach(self::$routes as $route) {
			if ($route->name === $name) {
				return $route->route;
			}
		}
	}
	
	public function init(){
		foreach(self::$routes as $route) {

			if(!in_array(strtoupper($route->requestMethod), $this->supportedHttpMethods))
			{
				return Response::invalidMethodHandler();
				
			}
			
			if (preg_match($this->getPattern($route), $this->request->requestUri, $matches) && $route->requestMethod == strtolower($this->request->requestMethod)) {
				
				if ($route->middleware){
					if(is_string($route->middleware)){
						$route->middleware = [$route->middleware];
					}
					
					$mid = new Middleware();
					foreach($route->middleware as $middleware){
						if(!$mid->$middleware()){
							return Response::NotAuthorized();
						}
					}
					
				}
				
				$this->back = true;
				
				if($route->view){
					View::render($route->view);
					return true;
				}
				
				if($route->requestMethod === "post") {
					if(!isset($this->request->post["token"]) || $this->request->post["token"] !== Session::get("token")){
						return Response::csrfRequestHandler();
					}
					
				}
				
				//Remove full match from array
				unset($matches[ 0 ]);
				$matches[] = $this->request;
				$class = 'App\Controllers\\' . $route->namespace ."\\". $route->controller;
				
				if (isset($route->controller)) {
					
					return call_user_func_array([ new $class(), $route->method ], $matches);
					
				} else {
					
					return call_user_func_array($route->method, $matches);
					
				}
			}
		}

		return Response::defaultRequestHandler();
	}
	
	public function __destruct()
	{
		if($this->back)
			Session::add("back",["uri" => $this->request->requestUri, "method" => $this->request->requestMethod]);
		Session::unFlash();
		$this->back = false;
	}
	
}
