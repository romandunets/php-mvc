<?php

	// Router Command Dispatcher
	class RouterCommandDispatcher
    {
		// URL Command Object
		protected $command;

		// Create and Initialize URL Interpreter with URL Command Object
		public function RouterCommandDispatcher($command)
		{
            $this->command = $command;
		}

		// Dispatch Initialized Command
		public function Dispatch()
		{
			// Get controller name
            $controllerName = $this->command->GetControllerName();
			// Require controller class
			Controller::Load($controllerName);
            
			// Set controller class name
			$controllerClass = Controller::GetClassName($controllerName);
			// Create new appropriate controller and initialize it with corresponding command			
            $controller = new $controllerClass($this->command);
			
            // Execute controller action
			$controller->Execute();
        }
    }