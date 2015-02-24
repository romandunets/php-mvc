<?php

	// Require Component Classes
	require_once('loader.config.php');				// Require Loader Configuration
	
	// Attempt to load undefined class
	function __autoload($className)
	{
		// Load class using Loader
		Load($className);
	}
	
	// Load file with specified name (and path). By default there will loaded all the application files. If file will not be found in specified by name place, function will perform a down-up search of the file if exact equals to false.
	function Load($name = ALL_FILES, $exact = false)
	{
		// Path to file
		$path = DEFAULT_LOAD_PATH;
		
		// Check if loading is not exact
		if(!$exact)
		{
			// Replace load namespace separator with directory separator
			$name = str_replace(NAMESPACE_SEPARATOR, DS, $name);
			
			// Get search path (add root path and remove file name)
			$path = ROOT . substr($name, 0, strrpos($name, DS));
			// Get file name
			$name = substr($name, strrpos($name, DS) + 1);
			
			// Check if file name contains default file extension
			if(substr($name, -strlen(APP_FILES_EXT)) != APP_FILES_EXT)
			{
				// Add default file extension to file name
				$name = $name . APP_FILES_EXT;
			}
		}
		
		// Check if file exist
		if(file_exists($path . DS . $name))
		{
			// Require file
			require_once($path . DS . $name);
		}
		// Check if loading is not exact
		else if(!$exact)
		{
			// Create search paths array
			$paths = array();
			
			// While path still contain root path
			while(strpos($path, ROOT) !== FALSE)
			{
				// Get the last directory separator position
				$position = strrpos($path, DS);
				// If position is real then use it to get parent directory from path else set root path
				$path = ($position == FALSE) ? ROOT : substr($path, 0, $position);
				
				// Collect all the application files with typical name
				$found = Find($name, $path);
				// Merge found files with current paths array
				$paths = array_merge($paths, $found);
			}
			
			// For each file in paths array
			for($index = 0; $index < sizeof($found); $index++)
			{
				// Make a warning log about non-optimized include because of search
				error_log('[WARNING] Non-optimized include: ' . $found[$index] . ' (trying to include: ' . $path . DS . $name . ');');
				// Require file
				require_once($found[$index]);
			}
		}
	}