<?php

	// Require Component Classes
	require_once('cache.config.php');		// Require Cache Configuration
	
	// Get Cache Data using Specified Cache ID
	function GetCache($cacheId)
	{
		// Set temporary cache file name
		$fileName = CACHE_DIRECTORY . $cacheId;
		
		// Check if temporary cache file already exist
		if (file_exists($fileName))
		{
			// Open file for reading and writing and place the file pointer at the beginning of it
			$file = fopen($fileName, 'r+');
			// Reads from file all the data
			$data = fread($file, filesize($cacheId));
			// Close file
			fclose($file);
			
			// Unserialize and return data
			return unserialize($data);
		}
		else
		{
			return null;
		}
	}
	
	// Set Cache Data using Specified Cache ID
	function SetCache($cacheId, $data)
	{
		// Set temporary cache file name
		$fileName = CACHE_DIRECTORY . $cacheId;
		
		// Open file for writing only, place the file pointer at the beginning of it and truncate the file to zero length. If the file does not exist, attempt to create it.
		$file = fopen($fileName, 'w');
		// Write to file serialized data
		fwrite($file, serialize($data));
		// Close file
		fclose($file);
	}