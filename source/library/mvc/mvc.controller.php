<?php

	// Abstract Controller Class
	abstract class Controller
    {
		// Controller Model Instance
		protected $model;
		// Router URL Command Instance
		protected $command;
		// Controller/Action Variable Set 
		protected $variables = array();
		
		// Create and Initialize Controller
		public function Controller($command = 'index')
        {
			// Initialize corresponding command instance
			$this->command = $command;
			
			// Get model class name
			$modelFileName = str_replace(CONTROLLER_CLASS_SUFFIX, '', get_class($this));
			// Get model class name
			$modelClassName = str_replace(CONTROLLER_CLASS_SUFFIX, MODEL_CLASS_SUFFIX, get_class($this));
			
			// Load model class
			Model::Load($modelFileName);
			// Check if class exist
			if(class_exists($modelClassName))
			{
				// Initialize new model instance
				$this->model = new $modelClassName;
			}
        }
		
		// Load Controller with Specified Name
		public static function Load($name)
		{
			// Get path of controller class with specified name
			$fileName = self::GetControllerPath($name);
			
			// Check if controller with specified name does not exists
			if (file_exists($fileName) == false)
			{
				// If it is set 'error' controller path
				$fileName = self::GetControllerPath(ERROR_CONTROLLER);
			}
			
			// Include and evaluate specified controller class file
			require_once($fileName);
		}
		
		// Get Controller Class Name with Specified Controller Name
		public static function GetClassName($name)
		{
			return $name . CONTROLLER_CLASS_SUFFIX;
		}
		
		// Get path of controller class with specified name
		protected static function GetControllerPath($name)
		{
			return (ROOT . CONTROLLER_DIRECTORY . DS . $name . DS . CONTROLLER_FILE_PREFIX . $name . CONTROLLER_FILE_EXTENSION);
		}
		
		// Get path of view with specified name
		protected function GetViewPath($name)
		{
			// Get meta name (directory name) using class name
			$metaname = strtolower(str_replace(CONTROLLER_CLASS_SUFFIX, "", get_class($this)));
			// Return path of view with specified name
			return (ROOT . VIEW_DIRECTORY . DS . $metaname . DS . VIEW_FILE_PREFIX . $metaname . METANAME_SEPARATOR . $name . VIEW_FILE_EXTENSION);
		}
		
		// Execute Action in Accordance to Provided Command
		public function Execute()
		{
			// Get action (method) name
			$callFunction = $this->command->GetActionName();
			// Check if action name is not empty. If it is, set default action
			$callFunction = (empty($callFunction)) ? DEFAULT_ACTION : $callFunction;
			
			// Check if action callable
            if (!is_callable(array($this, $callFunction)))
			{
				// Call render action of view with name of incalculable action using main template as function argument
				call_user_func_array(array($this, 'Render'), array($GLOBALS['template']['main']));
			}
			else
			{
				// Call the action
				call_user_func(array($this, $callFunction));
			}
		}
		
		// Return View Action Method using specified model and template
		protected function Render($template = null, $model = null)
		{
			// Get view name using class name
			$viewName = strtolower($this->command->GetActionName());
			// Set specified view path (location)
			$view = $this->GetViewPath($viewName);

			// Check if template is specified
			if ($template)
			{
				//	If it is, use it
				require(ROOT . $template);
			}
			else
			{
				// If not use only current view
				require($view);
			}
		}
		
		// Get Controller/Action Variable accordingly to specified name
		public function GetVariable($name)
		{
			return $this->variables[$name];
		}
		
		// Set Controller/Action Variable using specified name and value 
		public function SetVariable($name, $value)
		{
			$this->variables[$name] = $value;
		}
		
		// Default/Main Action Method
		protected function Index()
        {
			// Render index view using main template
			$this->Render($GLOBALS['template']['main']);
        }
    
		// Error Action Method
		protected function Error()
        {}
    }