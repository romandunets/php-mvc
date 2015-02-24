<?php
	
	// Configure Reporting
	function ConfigureReporting()
	{
		// Report all errors and warnings
		error_reporting(E_ALL);
			
		// Check development environment constant
		if (IS_DEVELOPMENT_ENVIRONMENT == true)
		{
			// Errors should be printed to the screen as part of the output 
			ini_set('display_errors', 'On');
		}
		else
		{
			// Errors should be hidden from the user
			ini_set('display_errors', 'Off');
			// Error messages should be logged to the server's error log
			ini_set('log_errors', 'On');
			// Set name of the file where script errors should be logged
			ini_set('error_log', ERROR_LOG_FILE);
		}
	}