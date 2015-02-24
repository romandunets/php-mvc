<?php
	
	// Abstract Model Class
	abstract class Model
    {		
		// Load Model with Specified Name
		public static function Load($name)
		{
			// Get path of model class with specified name
			$fileName = self::GetModelPath($name);
			
			// Check if model with specified name does not exists
			if (file_exists($fileName) == true)
			{
				// Include specified model class file
				require_once($fileName);
				// Load success
				return true;
			}
			else
			{
				// Load fail
				return false;
			}
		}
		
		// Get path of model class with specified name
		protected static function GetModelPath($name)
		{
			$name = strtolower($name);
			return (ROOT . MODEL_DIRECTORY . DS . $name . DS . MODEL_FILE_PREFIX . $name . MODEL_FILE_EXTENSION);
		}
    }