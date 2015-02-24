<?php

	// AJAX Class
	class AJAX
	{
		// Send JSON Response according to specified data and action
		public static function Response($data = '', $action = DEFAULT_AJAX_ACTION)
		{
			// Initialize response data array
			$response = array(
				'data' => $data,
				'action' => $action
			);
			
			// Convert and print response data array to JSON format
			echo json_encode($response);
		}
	}