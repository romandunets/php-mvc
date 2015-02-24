<?php
	
	// Contact Controller Class
	class ContactController extends Controller
	{
		// Index (automatically choose appropriate action)
		protected function Index()
		{
			if((!isset($_SESSION['CONTACT_MAILS'])) || (($_SESSION['LAST_MAIL_TIME'] + 60 * 60 * 24) < time()))
			{
				$_SESSION['CONTACT_MAILS'] = 3;
				$_SESSION['LAST_MAIL_TIME'] = time();
			}
			
			if (isset($_POST['name'], $_POST['message']))
			{
				if($_SESSION['CONTACT_MAILS'] > 0)
				{
					$to = 'romahalabuda@gmail.com';
					
					$message = array(
						'name' => $_POST['name'],
						'message' => $_POST['message']
					);
					
					$message['email'] = (!isset($_POST['email'])) ? '<not given>' : $_POST['email'];
					$subject = (!isset($_POST['subject'])) ? 'Contact' : $_POST['subject'];
					
					$message['ip'] = $_SERVER['REMOTE_ADDR'];
					$message['time'] = date('Y-m-d H:i:s');
					
					if((strlen($message['name']) > 0) && (strlen($message['message']) > 0))
					{
						$message = 
							"Type of Standard: " . $standard . "\n" . "\n" .
							"Question:" . "\n" . "\n" . $message['message'] . 
							"\n" . "\n" .
							"--------------------------------" . "\n" .
							"Sender information: " . "\n" .
							"\t" . "Name: " . $message['name'] . ";" . "\n" . 
							"\t" . "Email: " . $message['email'] . ";" . "\n" . 
							"\t" . "IP: " . $message['ip'] . ";" . "\n" . 
							"\t" . "Time: " . $message['time'] . ";";
						
						if(mail($to, $subject, $message))
						{
							$_SESSION['CONTACT_MAILS']--;
							// Send a JSON error response
							AJAX::Response("Your Message has been sent successfully.", "success");
							// Return false (operation fail)
							return true;
						}
						else
						{
							// Send a JSON error response
							AJAX::Response("An error occurred while sending the message. Please try to send the message again.", "error");
							// Return false (operation fail)
							return false;
						}
					}
					else
					{
						// Send a JSON error response
						AJAX::Response("Name and message cannot be empty. Please enter name and massage text to send the message.", "error");
						// Return false (operation fail)
						return false;
					}
				}
				else
				{
					// Send a JSON error response
					AJAX::Response("You have exceeded your daily message sending limit.", "error");
					// Return false (operation fail)
					return false;
				}
			}
			else
			{
				// Render page
				$this->Render($GLOBALS['template']['main'], $_SESSION['CONTACT_MAILS']);
			}
		}
	}