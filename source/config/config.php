<?php
	
	// Location Constants Configuration
	define('DS' , DIRECTORY_SEPARATOR);											// Directory Separator
	define('US' , '/');															// URL Separator
	define('PROTOCOL_DELIMITER', ':' . US . US);								// URL HTTP Prefix
	define('URL_PREFIX', 'http' . PROTOCOL_DELIMITER);							// Protocol Delimiter
	define('DOMAIN', URL_PREFIX . $_SERVER['HTTP_HOST']);						// Domain Base Path (Public Root)
	define('PUBLIC_DIRECTORY', 'public');										// Public Directory Name
	define('ERROR_LOG_FILE', ROOT . 'tmp' . DS . 'logs' . DS . 'error.log');	// Error Log File
	define('APP_FILES_EXT', '.php');											// Application Files Extension
	
	// Database Constants Configuration
	define('DB_HOST', '127.0.0.1');						// Connection Host (mysql1.000webhost.com)
	define('DB_USERNAME', 'root');						// Connection Username (a5276889_root)
	define('DB_PASSWORD', 'XSIytdo71645');    			// Database Password (Phenom945!)
	define('DB_NAME', 'FM');    						// Database Name (a5276889_FM)	
	
	// Security Constants Configuration
	define('IS_DEVELOPMENT_ENVIRONMENT', TRUE);			// If Environment is Development
	define('IS_SECURE', FALSE);							// If SSL is Required
	
	// MVC & Routing Constants Configuration
	define('MVC_DIRECTORY', 'application');				// MVC Directory Name
	define('DEFAULT_CONTROLLER', 'home');				// Default Controller Name
	define('DEFAULT_ACTION', 'index');					// Default Action Name