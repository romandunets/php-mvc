<?php

	// General Constants Configuration
	/** DEFINED IN MAIN CONFIG FILE **/
	//define('DEFAULT_CONTROLLER', 'home');									// Default Controller Name
	/** DEFINED IN MAIN CONFIG FILE **/
	//define('DEFAULT_ACTION', 'index');									// Default Action Name
	define('METANAME_SEPARATOR', '.');										// Meta name separator
	
	// Model Constants Configuration
	define('MODEL_DIRECTORY', MVC_DIRECTORY . DS . 'models');				// Models Directory Location
	define('MODEL_FILE_PREFIX', 'model' . METANAME_SEPARATOR);				// Models File Prefix
	define('MODEL_FILE_EXTENSION', '.php');									// Models File Extension
	define('MODEL_CLASS_SUFFIX', 'Model');									// Model Class Suffix
	
	// Views Constants Configuration
	define('VIEW_DIRECTORY', MVC_DIRECTORY . DS . 'views');					// Views Directory Location
	define('VIEW_FILE_PREFIX', 'view' . METANAME_SEPARATOR);				// Views File Prefix
	define('VIEW_FILE_EXTENSION', '.php');									// Views File Extension
	
	// Controllers Constants Configuration
	define('CONTROLLER_DIRECTORY', MVC_DIRECTORY . DS . 'controllers');		// Controllers Directory Location
	define('CONTROLLER_FILE_PREFIX', 'controller' . METANAME_SEPARATOR);	// Controllers File Prefix
	define('CONTROLLER_FILE_EXTENSION', '.php');							// Controllers File Extension
	define('CONTROLLER_CLASS_SUFFIX', 'Controller');						// Controllers Class Suffix
	define('ERROR_CONTROLLER', 'error');									// Error Controller Name
	
	// Default Layout (View Templates) Configuration
	$template['main'] = VIEW_DIRECTORY . DS . 'shared' . DS . VIEW_FILE_PREFIX . 'shared' . METANAME_SEPARATOR . 'main' . VIEW_FILE_EXTENSION;		// Main Layout Location