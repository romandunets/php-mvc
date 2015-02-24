<?php

	// HTML Class
	class HTML
	{
		// Get URL Link String using Specified URL Argument
		public static function LinkToURL($url = null)
		{
			// Initialize link with null
			$link = null;
			
			// Check if URL argument is set
			if(isset($url))
			{
				// Set link as empty string
				$link = '';
			
				// Check if URL argument contains protocol delimiter
				if (strpos($url, PROTOCOL_DELIMITER) === FALSE)
				{
					// Add default URL prefix to link (http protocol)
					$link = URL_PREFIX;
				}
				
				// Add URL to link
				$link .= $url;
			}

			// Return link
			return $link;
		}

		// Get URL Link String using Specified Controller, Action and Parameters
		public static function LinkToAction($controller = null, $action = null, $parameters = null)
		{
			// Initialize link with domain part
			$link = DOMAIN;
			
			// Check if controller is set
			if(isset($controller))
			{
				// Add controller link part
				$link .= US . $controller;
			
				// Check if action is set
				if(isset($action))
				{
					// Add action link part
					$link .= US . $action;
					
					// Check if parameters is set
					if(isset($parameters))
					{
						// Add parameters link part
						$link .= US . $parameters;
					}
				}
			}
			
			// Return link
			return $link;
		}
		
		// Get Resource Link Based on Specified File Name
		public static function GetResourse($name)
		{
			// Initialize link with null
			$link = null;
			
			// Check if name is set
			if(isset($name))
			{
				// Set link as file URL and path to it through public directory
				$link = DOMAIN . US . PUBLIC_DIRECTORY . US . $name;
			}
			
			// Return link
			return $link;
		}
		
		// Return Resource Link using Specified File Name, Handler, File Extension and File Directory
		public static function LinkToResource($name, $handler, $extension, $directory)
		{
			// Check if file name contains specified file extension
			if(substr($name, -strlen($extension)) != $extension)
			{
				// Add specified file extension to file name
				$name = $name . $extension;
			}
			
			// Build specified files directory location path
			$path = ROOT . PUBLIC_DIRECTORY . DS . $directory;
			// Build specified file location based on fileName
			$location = $path . DS . $name;
			
			// Initialize empty result links array
			$links = array();
			
			// Check if file exist
			if(file_exists($location))
			{
				// Add the right link to result links array
				array_push($links, DOMAIN . US . PUBLIC_DIRECTORY . US . $directory . US . $name);
			}
			else
			{
				// Collect all the files with typical name and add them to result links array
				$links = array_merge($links, Find('*' . str_replace($extension, '', $name) . '*' . $extension, $path));
			}
			
			// Return links array
			return $links;
		}
	}