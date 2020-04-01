<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Auth;
use App\Request;
use App\Route;
use App\Router;
use App\Session;
use App\View;
use App\Database;
use App\Models\User;

require_once "../autoload.php";
require_once "../routes.php";

session_start();

if (!Session::exists("token")) {
	Session::add("token",bin2hex(random_bytes(32)));
}

Router::instance()->init();
