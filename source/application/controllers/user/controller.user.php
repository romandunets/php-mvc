<?php

	// User Controller Constants Configuration
	// Login Attempts Limit
	define('LOGIN_ATTEMPTS_LIMIT', 5);
	// Login Last Attempt Time (Past 5 Minutes)
	define('LAST_LOGIN_ATTEMPT_TIME', 5 * 60);
	
	// User Controller Class
	class UserController extends Controller
	{	
		// Index (automatically choose appropriate action)
		protected function Index()
		{
			// Check if user if logged in
			if(userController::CheckLogin() == true)
			{
				$this->Render($GLOBALS['template']['main'], $this->model->ReadById($_SESSION['userId'])[0]);
			}
			else
			{
				// Redirect to login page
				PerformAction('user', 'login');
			}
		}
		
		function Register()
		{
			if(in_array("validate", $this->command->GetParameters()))
			{
				foreach($_POST as $key => $value)
				{
					switch($key)
					{
						case 'username':
							// Read user data by username
							$user = $this->model->ReadByUsername($value);
							// Check if user is not equal null
							if (!empty($user))
							{
								AJAX::Response("This user name is already used. Please try to use another.", "error");
							}
							break;
							
						case 'email':
							// Read user data by email
							$user = $this->model->ReadByEmail($value);
							// Check if user is not equal null
							if (!empty($user))
							{
								AJAX::Response("This email address is already used. Please try to use another.", "error");
							}
							break;
							
						case 'website':
							// Read user data by website url
							$user = $this->model->ReadByWebsite($value);
							// Check if user is not equal null
							if (!empty($user))
							{
								AJAX::Response("This website URL is already used. Please try to use another.", "error");
							}
							break;
						
						case 'phone':
							// Read user data by phone number
							$user = $this->model->ReadByPhone($value);
							// Check if user is not equal null
							if (!empty($user))
							{
								AJAX::Response("This phone number is already used. Please try to use another.", "error");
							}
							break;
						
						case 'fax':
							// Read user data by fax number
							$user = $this->model->ReadByFax($value);
							// Check if user is not equal null
							if (!empty($user))
							{
								AJAX::Response("This fax number is already used. Please try to use another.", "error");
							}
							break;
					}
				}
				
				return true;
			}
			
			// Check if username and hashedPassword are setted (check data or generate form)
			if (isset($_POST['email'], $_POST['username'], $_POST['hashedPassword'], $_POST['category'], $_POST['firstName'], $_POST['secondName'], $_POST['honorific']))
			{
				// Get an email post variable and filters it
				$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
				// Get a username post variable and filters it
				$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
				// Get a hashedPassword post variable and filters it
				$password = filter_input(INPUT_POST, 'hashedPassword', FILTER_SANITIZE_STRING);
				// Get a category post variable and filters it
				$category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
				// Check if a company variable is setted; If is is, get and filters it; Else set it to null
				$company = ((isset($_POST['company'])) && (strlen($_POST['company']) > 0)) ? filter_input(INPUT_POST, 'company', FILTER_SANITIZE_STRING) : null;
				// Check if a specialist variable is setted; If is is, get and filters it; Else set it to null
				$specialist = (isset($_POST['specialist'])) ? filter_var_array($_POST['specialist'], FILTER_SANITIZE_STRING) : array();
				// Get a first name post variable and filters it
				$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
				// Get a second name post variable and filters it
				$secondName = filter_input(INPUT_POST, 'secondName', FILTER_SANITIZE_STRING);
				// Get a honorific post variable and filters it
				$honorific = filter_input(INPUT_POST, 'honorific', FILTER_SANITIZE_STRING);
				// Check if a website variable is setted; If is is, get and filters it; Else set it to null
				$website = ((isset($_POST['website'])) && (strlen($_POST['website']) > 0)) ? filter_input(INPUT_POST, 'website', FILTER_SANITIZE_STRING) : null;
				// Check if a phone variable is setted; If is is, get and filters it; Else set it to null
				$phone = ((isset($_POST['phone'])) && (strlen($_POST['phone']) > 0)) ? filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING) : null;
				// Check if a fax variable is setted; If is is, get and filters it; Else set it to null
				$fax = ((isset($_POST['fax'])) && (strlen($_POST['fax']) > 0)) ? filter_input(INPUT_POST, 'fax', FILTER_SANITIZE_STRING) : null;
				// Check if a address variable is setted; If is is, get and filters it; Else set it to null
				$address = ((isset($_POST['address'])) && (strlen($_POST['address']) > 0)) ? filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING) : null;
				// Check if a city variable is setted; If is is, get and filters it; Else set it to null
				$city = ((isset($_POST['city'])) && (strlen($_POST['city']) > 0)) ? filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING) : null;
				// Check if a state variable is setted; If is is, get and filters it; Else set it to null
				$state = ((isset($_POST['state'])) && (strlen($_POST['state']) > 0)) ? filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING) : null;
				// Check if a zip variable is setted; If is is, get and filters it; Else set it to null
				$zip = ((isset($_POST['zip'])) && (strlen($_POST['zip']) > 0)) ? filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_STRING) : null;
				// Check if a country variable is setted; If is is, get and filters it; Else set it to null
				$country = ((isset($_POST['country'])) && (strlen($_POST['country']) > 0)) ? filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING) : null;

				// Check if password length is not equal 128 characters
				if(strlen($password) != 128)
				{
					// Generate error
					AJAX::Response("An error occurred while creating the Account. Please try to create it again.", "error");
					return false;
				}
				
				// Read user data by username
				$user = $this->model->ReadByUsername($username);
				// Check if user is not equal null
				if (!empty($user))
				{
					AJAX::Response("This username is already used. Please try to use another.", "error");
					return false;
				}
				
				// Create a random salt
				$salt = hash('sha512', uniqid($this->generateRandomSalt(16), TRUE)); // openssl_random_pseudo_bytes
				// Create salted password 
				$password = hash('sha512', $password . $salt);
 
				// Insert the new user into the database
				if($this->model->CreateUser($email, $username, $password, $salt, $category, $company, $specialist, $firstName, $secondName, $honorific, $website, $phone, $fax, $address, $city, $state, $zip, $country))
				{					
					// Read user data by username 
					$user = $this->model->ReadByUsername($username);

					// Check result is not null
					if (!empty($user))
					{
						// Set-up a session
						$this->SetUpSession($user);
						// Redirect to user page
						AJAX::Response(HTML::LinkToAction('user'), 'redirect');
						
						return true;
					}
				}
				
				// Generate error
				AJAX::Response("An error occurred while creating the Account. Please try to create it again.", "error");
				return false;
			}
			else
			{
				// Render register page
				$this->Render($GLOBALS['template']['main']);
				return true;
			}
		}
		
		// Login (check data or generate page)
		function Login()
		{
			if(in_array("validate", $this->command->GetParameters()))
			{
				foreach($_POST as $key => $value)
				{
					switch($key)
					{
						case 'username':
							break;
						case 'password':
							break;
					}
				}
				
				return true;
			}
			
			// Check if username and hashedPassword are setted (check data or generate form)
			if (isset($_POST['username'], $_POST['hashedPassword']))
			{
				// Get user name
				$username = $_POST['username'];
				// Get hashed password
				$password = $_POST['hashedPassword'];
				
				// Read user data by username 
				$user = $this->model->ReadByUsername($username)[0];
				
				// Check result is not null
				if ($user != null)
				{
					// Hash the password with a salt read from database 
					$password = hash("sha512", $password . $user['salt']);
					
					// Check for a brute forcing
					if($this->CheckBrute($user['id']) == true)
					{
						AJAX::Response("This account is blocked for 5 minutes due to unauthorized access attempts. Please try to contact with administrator.", "error");
					}
					else
					{
						if ($user['status'] == 'active')
						{
							// Check if the password in the database matches the password the user submitted
							if ($password == $user['password'])
							{
									// Password is correct: set-up a session
									$this->SetUpSession($user);
									// Login successful: redirect to user page
									AJAX::Response(HTML::LinkToAction('user'), "redirect");
							}
							else
							{
								// Password is not correct: record this attempt into database
								$this->model->CreateLoginAttempt($user['id'], time());
								
								AJAX::Response("Username and Password are not correct. Please try to login again.", "error");
							}
						}
						else
						{
							AJAX::Response("This is account is inactive. Please try to contact with administrator.", "error");
						}
					}
				}
				else
				{
					AJAX::Response("Username and Password are not correct. Please try to login again.", "error");
				}
			}
			else
			{
				// Render login page
				$this->Render($GLOBALS['template']['main']);
			}
		}
		
		// Edit
		function Edit()
		{
			// Check if username is setted to submit data
			if (isset($_POST['username']))
			{
				// Build up a new user models
				$model = array(
					'username' => $_POST['username']
				);
				
				// Read user data by username
				$user = $this->model->ReadByUsername($model['username'])[0];
				// Check if user is not equal null
				if ($user != null)
				{
					if($user['id'] == $_SESSION["userId"])
					{
						// Send a JSON error response
						AJAX::Response("This username is already Yours.", "error");
					}
					else
					{
						// Send a JSON error response
						AJAX::Response("This username is already used. Please try to use another.", "error");
					}
					
					// Return false (operation fail)
					return false;
				}
				
				// Update user model
				if($this->model->Update($_SESSION["userId"], $model) != null)
				{
					// Set a new current session username
					$_SESSION['username'] = $_POST['username'];
					// Redirect to user edit page
					AJAX::Response(null, "update");
					// Return true (operation success)
					return true;
				}
				else
				{
					// Send a JSON error response
					AJAX::Response("An error occurred while submitting changes. Please try to submit it again.", "error");
					// Return false (operation fail)
					return false;
				}
			}
			
			// Render edit account page
			$this->Render($GLOBALS['template']['main'], $this->model->ReadById($_SESSION['userId'])[0]);
			// Return true (operation success)
			return true;
		}
		
		// Delete Account
		function Delete()
		{
			// Check if hashedPassword is setted
			if (isset($_POST['hashedPassword']))
			{
				// Get hashed password
				$password = $_POST['hashedPassword'];
				
				// Read user data by username 
				$user = $this->model->ReadById($_SESSION['userId'])[0];
				
				// Check result is not null
				if ($user != null)
				{
					// Hash the password with a salt read from database 
					$password = hash("sha512", $password . $user['salt']);
					
					// Check for a brute forcing
					if($this->CheckBrute($user['id']) == true)
					{
						AJAX::Response("This account is blocked for 5 minutes due to unauthorized access attempts. Please try to contact with administrator.", "error");
					}
					else
					{
						// Check if the password in the database matches the password the user submitted
						if ($password == $user['password'])
						{
							$model = array(
								'status' => 0
							);
							
							if($this->model->Update($_SESSION["userId"], $model) != null)
							{
								// Unset session variables
								unset($_SESSION["userId"], $_SESSION['username'], $_SESSION['loginString']);
								
								// Redirect to user page
								AJAX::Response(HTML::LinkToAction('user'), 'redirect');
								
								return true;
							}
							else
							{
								// Send a JSON error response
								AJAX::Response("An error occurred while deleting account. Please try to delete it again.", "error");
								// Return false (operation fail)
								return false;
							}
						}
						else
						{
							// Password is not correct: record this attempt into database
							$this->model->CreateLoginAttempt($user['id'], time());
							
							// Generate error
							AJAX::Response("Your current Password is not correct. Please enter correct current Password.", "error");
							return false;
						}
					}
				}
				else
				{
					// Send a JSON error response
					AJAX::Response("An error occurred while deleting account. Please try to delete it again.", "error");
					// Return false (operation fail)
					return false;
				}
			}
			else
			{
				// Render login page
				$this->Render($GLOBALS['template']['main']);
			}
		}
		
		// Logout
		function Logout()
		{
			// Unset session variables
			unset($_SESSION["userId"], $_SESSION['username'], $_SESSION['loginString']);
			// Redirect to user page
			PerformAction('user');
		}
		
		function SetUpSession($user)
		{
			print_r($user);
			// Get the user-agent string
			$user_browser = $_SERVER["HTTP_USER_AGENT"];
			
			// XSS protection
			$id = preg_replace("/[^0-9]+/", "", $user['id']);
			$_SESSION["userId"] = $id;
			
			// XSS protection
			$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $user['username']);
			$_SESSION['username'] = $username;
			
			$_SESSION['loginString'] = hash('sha512', $user['password'] . $user_browser);
		}
		
		// Edit
		function ChangePassword()
		{
			if (isset($_POST['hashedCurrentPassword'], $_POST['hashedNewPassword']))
			{
				// Get old hashed password
				$currentPassword = $_POST['hashedCurrentPassword'];
				// Get new hashed password
				$newPassword = $_POST['hashedNewPassword'];
				
				// Read user data by username 
				$user = $this->model->ReadById($_SESSION['userId'])[0];
				
				// Check result is not null
				if ($user != null)
				{
					// Hash the password with a salt read from database 
					$currentPassword = hash('sha512', $currentPassword . $user['salt']);
					
					// Check for a brute forcing
					if($this->CheckBrute($user['id']) == true)
					{
						// Send a JSON error response
						AJAX::Response("This account is blocked for 5 minutes due to unauthorized access attempts. Please try to contact with administrator.", "error");
						// Operation fail
						return false;
					}
					else
					{
						// Check if the password in the database matches the password the user submitted
						if ($currentPassword == $user['password'])
						{
							// Get a hashedPassword post variable and filters it
							$newPassword = filter_input(INPUT_POST, 'hashedNewPassword', FILTER_SANITIZE_STRING);

							// Check if password length is not equal 128 characters
							if(strlen($newPassword) != 128)
							{
								// Generate error
								AJAX::Response("An error occurred while changing the password. Please try to change it again.", "error");
								// Operation fail
								return false;
							}
							
							// Check if new password is the same as current password
							if($newPassword == $currentPassword)
							{
								// Generate error
								AJAX::Response("The new password cannot be the same as current. Please try to change new password.", "error");
								// Operation fail
								return false;
							}
							
							// Create a random salt
							$salt = hash('sha512', uniqid($this->generateRandomSalt(16), TRUE)); // openssl_random_pseudo_bytes
							// Create salted password 
							$newPassword = hash('sha512', $newPassword . $salt);
			 
							$model = array(
								'password' => $newPassword,
								'salt' => $salt
							);
							
							// Update a user with the new password
							if($this->model->Update($user['id'], $model))
							{
								// Get the user-agent string
								$user_browser = $_SERVER["HTTP_USER_AGENT"];
								
								// XSS protection
								$id = preg_replace("/[^0-9]+/", "", $user['id']);
								$_SESSION["userId"] = $id;
								
								// XSS protection
								$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $user['username']);
								$_SESSION['username'] = $username;
								
								$_SESSION['loginString'] = hash('sha512', $newPassword . $user_browser);
								
								// Login successful: redirect to user page
								AJAX::Response("The current password was successfully changed", "success");
								return true;
							}
							else
							{
								// Generate error
								AJAX::Response("An error occurred while changing the password. Please try to change it again.", "error");
								return false;
							}						
						}
						else
						{
							// Password is not correct: record this attempt into database
							$this->model->CreateLoginAttempt($user['id'], time());
							// Generate error
							AJAX::Response("Your current Password is not correct. Please enter correct current Password.", "error");
							
							// Fail
							return false;
						}
					}
				}
				else
				{
					// Generate error
					AJAX::Response("An error occurred while changing the password. Please try to change it again.", "error");
					return false;
				}
			}
			
			// Render edit account page
			$this->Render($GLOBALS['template']['main'], $this->model->ReadById($_SESSION['userId'])[0]);
		}
		
		// Check user id for brute forcing
		function CheckBrute($userId)
		{
			// Get time stamp of current time 
			$now = time();
			// Set last login attempt time (past 5 minutes)
			$time = $now - LAST_LOGIN_ATTEMPT_TIME;
	
			// Read number of user logging attempts from specified time
			$attempts = $this->model->ReadLoginAttempts($userId, $time);
			
			// Check number of attempts for limit
			if ($attempts > LOGIN_ATTEMPTS_LIMIT)
			{
				// User id is brute forcing
				return true;
			}
			else
			{
				// User id is not brute forcing
				return false;
			}
		}
		
		public function CheckLogin()
		{		
			// Check if all session variables are set
			if(isset($_SESSION['userId'], $_SESSION['loginString'], $_SESSION['username']))
			{
				$id = $_SESSION['userId'];
				$login = $_SESSION['loginString'];
				$username = $_SESSION['username'];

				$model = new UserModel();
				// Read user data by username 
				$user = $model->ReadById($id)[0];

				// Check result is not null
				if ($user != null)
				{
					// Get the user-agent string of the user
					$browser = $_SERVER['HTTP_USER_AGENT'];
					$check = hash('sha512', $user['password'] . $browser);

					if(($check == $login) && ($user['status'] == 'active'))
					{
						return true;
					}
				}
			}
			
			return false;
		}
		
		function generateRandomSalt($length)
		{
			$validCharacters = 'abcdefghijklmnopqrstuvwxyz0123456789';
			$result = '';
			
			for($index = 1; $index < $length; $index++)
			{
				$character = rand(0, strlen($validCharacters)-1);
				$result .= $validCharacters{$character};
			}
			
			return $result;
		}
	}