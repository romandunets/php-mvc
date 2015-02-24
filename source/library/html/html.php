<?php

	// Require HTML Configuration
	require_once('html.config.php');
	// Require HTML Class
	require_once('html.html.php');
	
	// Print URL Link String using Specified URL Argument
	function LinkToURL($url = null)
	{
		// Print URL link using HTML class
		echo HTML::LinkToURL($url);
	}

	// Print URL Link String using Specified Controller, Action and Parameters
	function LinkToAction($controller = null, $action = null, $parameters = null)
	{
		// Print URL link using HTML class
		echo HTML::LinkToAction($controller, $action, $parameters);
	}
	
	// Print Resource Link Based on Specified File Name
	function GetResourse($name)
	{
		// Print URL link using HTML class
		echo HTML::GetResourse($name);
	}
	
	// Include JavaScript Link Based on Specified Name
	function IncludeJS($name)
	{
		// Include resource using specified name, JS handler, JS files extension and JS directory
		IncludeResource(
			$name,
			'GetJSIncludeString',
			JS_FILES_EXT,
			JS_DIRECTORY);
	}
	
	function GetJSIncludeString($url)
	{
		// Return JS include
		return "<script type='text/javascript' language='javascript' src='" . $url . "'></script>" . "\n";
	}
	
	// Include CSS Link Based on Specified Name and Media String
	function IncludeCSS($name, $media = null)
	{
		// Include resource using specified name, CSS handler, CSS files extension and CSS directory
		IncludeResource(
			$name,
			'GetCSSIncludeString',
			CSS_FILES_EXT,
			CSS_DIRECTORY);
	}
	
	function GetCSSIncludeString($url)
	{
		// CSS media configuration
		global $media;
		// Print JS include
		echo "<link rel='stylesheet' type='text/css'" . ((($media != null) && (strlen($media) > 0)) ? (" media='" . $media . "'") : ""). " href='" . $url . "'>" . "\n";
	}
	
	// Include Resource using Specified File Name, Handler, File Extension and File Directory
	function IncludeResource($name, $handler, $extension, $directory)
	{
		// Collect all the links
		$found = HTML::LinkToResource($name, $handler, $extension, $directory);
		
		// For each link in array
		for($index = 0; $index < sizeof($found); $index++)
		{
			// Make a warning log about non-optimized JS include because of search
			error_log('[WARNING] Non-optimized include: ' . $found[$index] . ' (trying to include: ' . $name . ');');
			// Call specified handler
			echo $handler($found[$index]);
		}
	}