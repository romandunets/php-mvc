<?php

	// Require Component Classes
	require_once('router.config.php');									// Require Router Configuration
	require_once('router.command.php');									// Require RouterCommand Class
	require_once('router.urlinterpreter.php');							// Require RouterUrlInterpreter Class
	require_once('router.commanddispatcher.php');						// Require RouterCommandDispatcher Class
	
	// Redirect to Specified Location (URL)
	function Redirect($url)
	{
		// Send a raw HTTP request to the specified location
		header('Location: ' . $url);
		// Exit from the current script
		exit();
	}
	
	// Perform Routing Procedures
	function Route()
	{
		// Create router URL interpretor
		$urlInterpreter = new RouterURLInterpreter();
		// Get command using router URL interpretor
		$command = $urlInterpreter->GetCommand();
		// Create router command dispatcher based on existed command
		$commandDispatcher = new RouterCommandDispatcher($command);
		// Dispatch and route
		$commandDispatcher->Dispatch();
	}
	
	// Perform Specified Command (Using as Arguments Controller Name, Action Name and Parameters)
	function PerformAction($controllerName = DEFAULT_CONTROLLER, $actionName = DEFAULT_ACTION, $parameters = array())
	{
		// Create a new Router command using specified arguments
		$command = new RouterCommand($controllerName, $actionName, $parameters);
		// Create router command dispatcher based on created command
		$commandDispatcher = new RouterCommandDispatcher($command);
		// Dispatch and route
		$commandDispatcher->Dispatch();
	}