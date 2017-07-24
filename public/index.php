<?php
ini_set('display_errors', 1);

require '../vendor/autoload.php';
require '../core/bootstrap.php';

use App\Core\{Router, Request};

$request = new Request;
Router::load('../app/routes.php')
	  ->direct($request);