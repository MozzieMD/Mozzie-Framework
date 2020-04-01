<?php

spl_autoload_register(function($class){
	$root = str_replace("public", "", $_SERVER['DOCUMENT_ROOT']) . DIRECTORY_SEPARATOR;
	$class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
	$classFile = $root.$class.".php";

	if(file_exists($classFile))
		include_once $classFile;
	else
		throw new Exception($class." not found");

});

include_once str_replace("public", "", $_SERVER['DOCUMENT_ROOT']) . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'functions.php';