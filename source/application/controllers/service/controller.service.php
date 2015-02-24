<?php

	// Service Controller Class
	class ServiceController extends Controller
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
					$certificates = implode("\n\t-", $_POST['certificate']);
					
					$turnover = $_POST['turnover'];
					$turnoverCurrency = $_POST['turnoverCurrency'];
					$staff = $_POST['staff'];
					
					$woodProductName = $_POST['woodProductName'];
					$woodProductOutput = $_POST['woodProductOutput'];
					$woodProductOutputType = $_POST['woodProductOutputType'];
					
					$woodProducts = "";
					for($index = 0; (($index < count($woodProductName)) && ($index < count($woodProductOutput)) && ($index < count($woodProductOutputType))); $index++)
					{
						$woodProducts .= 
							"\n" .
							"\t" . "Wood Product " . ($index + 1) . "\n" .
							"\t\t" . "Product Name: " . $woodProductName[$index] . "\n" .
							"\t\t" . "Annual Output: " . $woodProductOutput[$index] . " (" . $woodProductOutputType[$index] . ")" . "\n";
					}
					
					$woodProductSupply = $_POST['woodProductSupply'];
					$woodProductSupplyVolume = $_POST['woodProductSupplyVolume'];
					$woodProductSupplyVolumeType = $_POST['woodProductSupplyVolumeType'];
					$woodProductSupplier = $_POST['woodProductSupplier'];
					
					$woodProductSuppliers = "";
					for($index = 0; (($index < count($woodProductSupply)) && ($index < count($woodProductSupplyVolume)) && ($index < count($woodProductSupplyVolumeType)) && ($index < count($woodProductSupplier))); $index++)
					{
						$woodProductSuppliers .= 
							"\n" .
							"\t" . "Wood Product Supplier " . ($index + 1) . "\n" .
							"\t\t" . "Product Name: " . $woodProductSupply[$index] . "\n" .
							"\t\t" . "Volume: " . $woodProductSupplyVolume[$index] . " (" . $woodProductOutputType[$index] . ")" . "\n" .
							"\t\t" . "Supplier: " . $woodProductSupplier[$index] . "\n";
					}
					
					$iso9001 = (isset($_POST['iso9001'])) ? $_POST['iso9001'] : 'non-certified';
					$iso14000 = (isset($_POST['iso14000'])) ? $_POST['iso14000'] : 'non-certified';
					$enquiry = $_POST['enquiry'];
					
					$username = $_SESSION['username'];
					$ip = $_SERVER['REMOTE_ADDR'];
					$time = date('Y-m-d H:i:s');
					
					$message = 
						"Service Order" . "\n" . "\n" . "\n" .
						"Type of Standard: " . $standard . "\n" . "\n" .
						"Types of Certificates: " . "\n\t-" . $certificates . "\n" . "\n" .
						"Organisation Information " . "\n" .
						"\t" . "Annual Turnover of the Company: " . $turnover . " (" . $turnoverCurrency . ")\n" .
						"\t" . "Number of Staff in the Company: " . $staff . " (persons)" . "\n" . "\n" .
						"Wood Products" . $woodProducts . "\n" .
						"Wood Product Suppliers" . $woodProductSuppliers . "\n" .
						"Additional Information " . "\n" .
						"\t" . "The organization is " . $iso9001 . " according to ISO 9000" . "\n" .
						"\t" . "The organization is " . $iso14000 . " according to ISO 14000 / EMAS" . "\n" .
						"\t" . "Enquiry: " . "\n" . $enquiry . "\n" .
						"--------------------------------" . "\n" . "\n" .
						"Sender information " . "\n" .
						"\t" . "Username: " . $username . "\n" . 
						"\t" . "IP: " . $ip . "\n" . 
						"\t" . "Time: " . $time;
					
					if(mail($to, "Order", $message))
					{
						//$_SESSION['CONTACT_MAILS']--;
						// Send a JSON error response
						AJAX::Response("Your order has been sent successfully.", "success");
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
				
				$this->Render($GLOBALS['template']['main'], $userController->model->ReadById($_SESSION['userId']));
			}
			else
			{
				// Redirect to login page
				PerformAction('user', 'login');
			}
		}
	}