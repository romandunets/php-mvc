<?php
	
	// General Constants Configuration	
	/** DEFINED IN MAIN CONFIG FILE **/
	//define('DEFAULT_CONTROLLER', 'home');				// Default Controller Name
	/** DEFINED IN MAIN CONFIG FILE **/
	//define('DEFAULT_ACTION', 'index');				// Default Action Name
	
	// Routing Rules Set (pattern => result)
	$routing = array(
		"{home}" => "",
		"{home/index/*}" => ""
	);
	
	// Transformation Rules Set (pattern => result)
	$transformation = array(
		"{login}" => "user/login",
		"{logout}" => "user/logout",
		"{^register}" => "user/register"
	);