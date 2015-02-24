<?php
	
	// Help Controller Class
	class HelpController extends Controller
	{
		// Index (automatically choose appropriate action)
		protected function Index()
		{
			Controller::Load('user');
			$userController = new UserController();
			
			// Check if user if logged in
			if($userController->CheckLogin() == true)
			{
				if(isset($_POST['standard']))
				{
					$to = 'romahalabuda@gmail.com';
					
					$standard = $_POST['standard'];
					$subject = (!isset($_POST['subject'])) ? 'Question' : $_POST['subject'];
					$question = $_POST['question'];
					
					$username = $_SESSION['username'];
					$ip = $_SERVER['REMOTE_ADDR'];
					$time = date('Y-m-d H:i:s');
					
					$message = 
						"Question Request" . "\n" . "\n" . "\n" .
						$question . 
						"\n" . "\n" .
						"--------------------------------" . "\n" . "\n" .
						"Sender information " . "\n" .
						"\t" . "Username: " . $username . "\n" . 
						"\t" . "IP: " . $ip . "\n" . 
						"\t" . "Time: " . $time;
					
					if(mail($to, $subject, $message))
					{
						//$_SESSION['CONTACT_MAILS']--;
						// Send a JSON error response
						AJAX::Response("Your question has been sent successfully.", "success");
						// Return false (operation fail)
						return true;
					}
					else
					{
						// Send a JSON error response
						AJAX::Response("An error occurred while sending the question. Please try to send the question again.", "error");
						// Return false (operation fail)
						return false;
					}
				}
				
				$this->Render($GLOBALS['template']['main'], $userController->model->ReadById($_SESSION['userId']));
			}
			else
			{
				// Redirect to login page
				PerformAction('user', 'login');
			}
		}
	}