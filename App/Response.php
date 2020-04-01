<?php


namespace App;


class Response
{
	private $request;
	private static $instance;
	
	public function __construct($request) {
		
		$this->request = $request;
		
	}
	
	public static function instance(){
		if (!self::$instance)
			self::$instance = new self(new Request());
		return self::$instance;
	}
	
	public static function invalidMethodHandler()
	{
		return Router::redirect("/");
	}
	
	public static function defaultRequestHandler()
	{
		header(self::instance()->request->serverProtocol." 404 Not Found");
		return false;
	}
	
	public static function csrfRequestHandler()
	{
		return Router::redirect("/");
	}
	
	public static function NotAuthorized(){
		return Router::redirect("/");
	}
}