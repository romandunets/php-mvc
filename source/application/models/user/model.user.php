<?php

	// User Model Class
	class UserModel extends SQLModel
	{
		// Create and Initialize User Model
		public function __construct()
        {
			parent::__construct('user');
		}
		
		// Create User Data
		public function CreateUser($email, $username, $password, $salt, $category, $company, $specialist, $firstName, $secondName, $honorific, $website, $phone, $fax, $address, $city, $state, $zip, $country)
		{
			$userId = 0;
			
			// Prepare an SQL statement for execution
			if($statement = $this->sql->GetConnection()->prepare("INSERT INTO user (role, status, email, username, password, salt, category, company, firstName, secondName, honorific, website, phone, fax, address, city, state, zip, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))
			{
				// Bind username parameter
				$statement->bind_param('iissssisssisssssssi', 100, 100, $email, $username, $password, $salt, 1 /* $category */, $company, $firstName, $secondName, 1 /* $honorific */, $website, $phone, $fax, $address, $city, $state, $zip, 1 /* $country */);
				// Execute prepared query and return result
				print $statement->execute() ? "t" : "f";
				// Get inserted row user id
				$userId = $statement->insert_id;
			}
			
			foreach($specialist as $value)
			{
				// Prepare an SQL statement for execution
				if($statement = $this->sql->GetConnection()->prepare("SELECT id FROM userspecialization WHERE name = ? LIMIT 1"))
				{
					$userSpecializationId = 0;
					
					// Bind id parameter
					$statement->bind_param('s', $value);
					// Execute prepared query
					$statement->execute();
					// Store result of the query
					$statement->store_result();
					
					if($statement->num_rows == 1)
					{
						// Binds variables to a prepared statement for result storage
						$statement->bind_result($userSpecializationId);
						// Fetch results from a prepared statement into the bound variables
						$statement->fetch();	
					}
					else
					{
						// Prepare an SQL statement for execution
						if($statement = $this->sql->GetConnection()->prepare("INSERT INTO userspecialization (name) VALUES (?)"))
						{
							// Bind user specialization parameter
							$statement->bind_param('s', $value);
							// Execute prepared query and return result
							$statement->execute();
							// Get inserted row user specialization id
							$userSpecializationId = $statement->insert_id;
						}
					}
					
					// Prepare an SQL statement for execution
					if($statement = $this->sql->GetConnection()->prepare("INSERT INTO userspecializationstouser (userId, specializationId) VALUES (?, ?)"))
					{
						// Bind user specialization parameter
						$statement->bind_param('ii', $userId, $userSpecializationId);
						// Execute prepared query and return result
						$statement->execute();
					}
				}
			}
			
			// Create user fail
			return true;
		}
		
		// Override Read Function (Add Columns Specification)
		public function Read($filters)
		{
			return $this->sql->Select($this->table, $filters, array('id', 'role', 'status', 'email', 'username', 'password', 'salt'), array('role' => 'name', 'status' => 'name'));
		}
		
		// Read User Entity by Specified Id
		public function ReadById($id)
		{
			return $this->Read(array('id' => $id));
		}
		
		// Read User Entity by Specified Username
		public function ReadByUsername($username)
		{
			return $this->Read(array('username' => $username));
		}
		
		// Read User Entity by Specified Email
		public function ReadByEmail($email)
		{
			return $this->Read(array('email' => $email));
		}

		// Read User Entity by Specified Website URL
		public function ReadByWebsite($website)
		{
			return $this->Read(array('website' => $website));
		}
		
		// Read User Entity by Specified Phone Number
		public function ReadByPhone($phone)
		{
			return $this->Read(array('phone' => $phone));
		}
		
		// Read User Entity by Specified Fax Number
		public function ReadByFax($fax)
		{
			return $this->Read(array('fax' => $fax));
		}
		
		// Read Number of User Login Attempts from Specified Time
		public function ReadLoginAttempts($userId, $time)
		{
			// Set default result
			$result = null;
			
			// Prepare an SQL statement for execution
			if($statement = $this->sql->GetConnection()->prepare("SELECT time FROM LoginAttempt WHERE userId = ? AND time > '$time'"))
			{
				// Bind userId parameter
				$statement->bind_param('i', $userId);
				// Execute prepared query
				$statement->execute();
				// Store result of the query
				$statement->store_result();
				
				// Get number of rows and set it as result
				$result = $statement->num_rows;
			}
			
			// Return result
			return $result;
		}
		
		// Create (Add) New User Login Attempts using Specified User ID and Time
		public function CreateLoginAttempt($userId, $time)
		{
			// Set default result
			$result = null;
			
			// Prepare an SQL statement for execution
			if($statement = $this->sql->GetConnection()->prepare("INSERT INTO LoginAttempt(userId, time) VALUES (?, '$time')"))
			{
				// Bind userId parameter
				$statement->bind_param('i', $userId);
				// Execute prepared query
				$statement->execute();
				// Store result of the query
				$statement->store_result();
				
				// Get number of rows and set it as result
				$result = $statement->num_rows;
			}
			
			// Return result
			return $result;
		}
	}