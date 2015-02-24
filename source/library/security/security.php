<?php

	// Require Component Classes
	require_once('security.config.php');				// Require Security Configuration
	
	// Start Secure Session
	function StartSession()
	{
		// Check if application configuration require SSL and if connection uses it
		if(IS_SECURE && $_SERVER['HTTPS'] != 'on')
		{
			// Make a notice log about non-ssl connection attempt
			error_log('[NOTICE] Non-SSL connection attempt;');
			// Redirect to the same page using https 
			Redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		}
		
		// Set custom session id
		$sessionName = SESSION_NAME;
		// Get secure status
		$isSecure = IS_SECURE;
		// Stop JavaScript being able to access the session id
		$isHttpOnly = true;
		
		// Force cookies usage to store the session id on the client side; Check if setting was done
		if (ini_set('session.use_only_cookies', 1) === FALSE)
		{
			// Make an error log about impossibility of cookies usage to store the session id on the client side
			error_log('[ERROR] Cannot force cookies use to store the session id on the client side; Could not initiate a safe session;');
			// Redirect to the error page using 
			Redirect('error.php?error=Could not initiate a safe session.');
		}
		
		// Get current session cookies parameters
		$cookieParams = session_get_cookie_params();
		// Set current session cookies parameters (last two)
		session_set_cookie_params($cookieParams['lifetime'], $cookieParams['path'], $cookieParams['domain'], $isSecure, $isHttpOnly);
		
		// Set specified current session name
		session_name($sessionName);
		// Start new or resume existing session
		session_start();
		// Update the current session id with a newly generated one
		session_regenerate_id(); 
	}

	// Remove Magic Quotes from GET, POST and COOKIE
	function RemoveMagicQuotesGPC()
	{
		// Check magic quotes state for GPC
		if (get_magic_quotes_gpc())
		{
			// Remove magic quotes in GET
			$_GET = RemoveSlashes($_GET);
			// Remove magic quotes in POST
			$_POST = RemoveSlashes($_POST);
			// Remove magic quotes in COOKIE
			$_COOKIE = RemoveSlashes($_COOKIE);
		}
	}
	
	// Remove Backslashes
	function RemoveSlashes($value)
	{
		// If value is array repeat the function for each element as argument, else remove backslashes
		$value = is_array($value) ? array_map('RemoveSlashes', $value) : stripslashes($value);
		// Return clear value
		return $value;
	}
	
	// Unregister Globals
	function UnregisterGlobals()
	{
		// Check registration of the EGPCS (Environment, GET, POST, Cookie, Server) variables as global
		if (ini_get('register_globals'))
		{
			// Create array with the most common global variables
			$array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
			
			// Check every global variable
			foreach ($array as $value)
			{
				// Check every variable inside
				foreach ($GLOBALS[$value] as $key => $var)
				{
					// Unset value
					unset($GLOBALS[$key]);
				}
			}
		}
	}