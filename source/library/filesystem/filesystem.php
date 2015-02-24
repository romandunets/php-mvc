<?php

	// Require Component Classes
	require_once('filesystem.config.php');		// Require Router Configuration
	
	// Find the file with specified name glob pattern to match ('*' by default), path to search (ROOT constant by default), glob flags (null by default), depth of search (-1 for unlimited (default), 0 for only current directory), current level of search (0 by default).
	function Find($pattern = '*', $path = ROOT, $flags = null, $depth = -1, $level = 0)
	{
		// Get all the pattern matches in the current directory.
		$files = glob($path . $pattern, $flags);
		// Get all the subdirectories of the current directory.
		$paths = glob($path . '*', GLOB_ONLYDIR);
	 
		// Check if current directory contain any subdirectories and check the limit of depth
		if (!empty($paths) && ($level < $depth || $depth == -1))
		{
			// Increase current depth level
			$level++;
			
			// Go through each subdirectory
			foreach ($paths as $subPath)
			{
				// Check is subdirectory contains the pattern match (recursive find method call)
				$found = Find($pattern, $subPath . DIRECTORY_SEPARATOR, $flags, $depth, $level);
				// Merge found files in the current directory with found files in subdirectory
				$files = array_merge($files, $found);
			}	
		}
		
		// Return files array
		return $files;
	}