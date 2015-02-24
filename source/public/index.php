<?php
	
	// General Definitions
	define('ROOT', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);	// Define Location Root
	
	// Require General Classes
	require_once(ROOT . 'config/config.php');					// Require Main Configuration
	
	require_once(ROOT . 'library/filesystem/filesystem.php');	// Require Filesystem Classes
	require_once(ROOT . 'library/loader/loader.php');			// Require Loader Classes
	require_once(ROOT . 'library/shared/shared.php');			// Require Shared Classes
	require_once(ROOT . 'library/sql/sql.php');					// Require SQL Classes
	require_once(ROOT . 'library/security/security.php');		// Require Security Classes
	require_once(ROOT . 'library/mvc/mvc.php');					// Require MVC Classes
	require_once(ROOT . 'library/router/router.php');			// Require Routing Classes
	require_once(ROOT . 'library/cache/cache.php');				// Require Cache Classes
	require_once(ROOT . 'library/html/html.php');				// Require HTML Classes
	require_once(ROOT . 'library/ajax/ajax.php');				// Require AJAX Classes
	
	ConfigureReporting();
	RemoveMagicQuotesGPC();
	UnregisterGlobals();
	
	StartSession();
	Route();