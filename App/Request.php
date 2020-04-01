<?php


namespace App;


use App\Interfaces\IRequest;


class Request
{
	
	public $requestMethod;
	public $serverProtocol;
	public $requestUri;
	public $post;
	
	function __construct()
	{
		$this->init();
	}
	
	private function init()
	{
		foreach ($_SERVER as $key => $value) {
			$this->{$this->toCamelCase($key)} = $value;
		}
		
		if ($this->requestMethod == "POST") {
			
			foreach ($_POST as $key => $value) {
				$this->post[ $key ] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}

		}
	}
	
	private function toCamelCase( $string )
	{
		$result = strtolower($string);
		
		preg_match_all('/_[a-z]/', $result, $matches);
		
		foreach ($matches[ 0 ] as $match) {
			$c = str_replace('_', '', strtoupper($match));
			$result = str_replace($match, $c, $result);
		}
		return $result;
	}

}