<?php

	// URL Interpreter Class
	class RouterUrlInterpreter
	{
		// URL Command Object
		protected $command;

		// Create and Initialize URL Interpreter with appropriate URL Command Object
		public function RouterURLInterpreter()
        {
			// Transform request URI to array
			$requestURI = explode(US, $_SERVER['REQUEST_URI']);
			// Transform current URI to array
            $scriptName = explode(US, $_SERVER['SCRIPT_NAME']);
			
			// Take unique elements from request URI (the rest of URI)
            $commandArray = array_diff_assoc($requestURI, $scriptName);
			// Put the differentiated key-value set to array (values only)
            $commandArray = array_values($commandArray);
			
			// Check URI for routing exceptions to redirect it
			$this->RouteURI(implode(US, $commandArray));
			// Check URI for routing exceptions to transform it
			$commandArray = $this->TransformURI(implode(US, $commandArray));
			
			// Get controller name (1); If it is empty, set default controller name
			$controllerName = (empty($commandArray[0])) ? DEFAULT_CONTROLLER : $commandArray[0];
			// Get action name (2); If it is empty, set default action name
            $actionName = (empty($commandArray[1])) ? DEFAULT_ACTION : $commandArray[1];
			// Get parameters array (the rest)
            $parameters = array_slice($commandArray, 2);
			
			// Create and Initialize URL Command Object with the given values
            $this->command = new RouterCommand($controllerName, $actionName, $parameters);
		}

		// Perform Custom URI Routing (Check URI for Routing Exceptions to Redirect it)
		function RouteURI($uri)
		{
			// Get routing set as a global
			global $routing;

			// Check every routing pattern
			foreach ($routing as $pattern => $result)
			{
				// Check if URI has a match with regular expression
				if (preg_match($pattern, $uri))
				{
					// Redirect using new URI
					Redirect(DOMAIN . US . $result);
				}
			}
		}
		
		// Perform Custom URI Transformation (Check URI for Routing Exceptions to Transform it)
		function TransformURI($uri)
		{
			// Get transformation set as a global
			global $transformation;

			// Check every transformation pattern
			foreach ($transformation as $pattern => $result)
			{
				// Check if URI has a match with regular expression
				if (preg_match($pattern, $uri))
				{
					// Replace regex match and return new transformed URI array
					return explode(US, preg_replace($pattern, $result, $uri));
				}
			}
			
			// Return specified as argument (old) URI array
			return explode(US, $uri);
		}
		
		// Returns URL Command Object in Accordance with Initial URI
		public function GetCommand()
		{
            return $this->command;
		}
	}