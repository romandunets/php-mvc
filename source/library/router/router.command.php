<?php

	// Router URL Command Class
	class RouterCommand
	{
		// Controller Name
		protected $controllerName = '';
		// Action Name
		protected $actionName = '';
		// Parameters Array
		protected $parameters = array();

		// Create and Initialize Router Command
		public function RouterCommand($controllerName, $actionName, $parameters)
		{
            $this->controllerName = $controllerName;
            $this->actionName = $actionName;
			$this->parameters = $parameters;
		}

		// Get Controller Name
		public function GetControllerName()
		{
			return $this->controllerName;
		}
		
		// Set Controller Name
		public function SetControllerName($controllerName)
		{
            $this->controllerName = $controllerName;
		}
		
		// Get Action Name
		public function GetActionName()
		{
			return $this->actionName;
		}

		// Set Action Name
		public function SetActionName($actionaName)
		{
			$this->actionName = $actionaName;
		}

		// Get Parameters Array
		public function GetParameters()
		{
            return $this->parameters;
		}

		// Set Parameters Array
		public function SetParameters($parameters)
		{
            $this->parameters = $parameters;
		}
	}