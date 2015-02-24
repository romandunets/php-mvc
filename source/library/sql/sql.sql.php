<?php

	// SQL Class
	class SQL
	{
		// Represent a Connection Between PHP and Database
		protected $connection;
		
		// Get Database Connection
		public function GetConnection()
		{
			return $this->connection;
		}
		
		// Connect to Database
		public function Connect($host = NULL, $username = NULL, $password = NULL, $database = NULL)
		{
			// Check if host name is not null; If it is, use default value
			$host = /*'p:' . */(($host == NULL) ? DB_HOST : $host);
			// Check if user name is not null; If it is, use default value
			$username = ($username == NULL) ? DB_USERNAME : $username;
			// Check if password is not null; If it is, use default value
			$password = ($password == NULL) ? DB_PASSWORD : $password;
			// Check if database is not null; If it is, use default value
			$database = ($database == NULL) ? DB_NAME : $database;
			
			// Open a new connection to the MySQL server using specified host name, user name, password and database name
			$this->connection = new mysqli($host, $username, $password, $database);
			
			// Check connection for errors
			if (mysqli_connect_error())
			{
				// Connection fail
				return FALSE;
			}			
			
			// Connection successful
			return TRUE;
		}
		
		// Disconnect from Database
		public function Disconnect()
		{
			// Close a previously opened database connection
			return mysqli_close($this->connection);
		}
		
		// Execute Specified by a String Query
		public function Query($queryString)
		{
			// Set default value of result variable
			$result = null;
			
			// Check if query string is not null
			if($queryString != null)
			{
				// Execute query and get result
				$result = mysqli_query($this->connection, $queryString);
			}
			
			// Return query result
			return $result;
		}
		
		// Insert Row into Specified Table by Key-Value Pairs
		public function Insert($tableName, $values)
		{
			// Initialize columns names string
			$keys = "";
			// Initialize values names string
			$values = "";
			
			// For each value in values array
			foreach ($values as $key => $value)
			{
				// Add key to keys string (and comma if appropriate)
				$keys .= ((strlen($keys) > 0) ? ", " : "" ) . $key;
				// Add value to values string (and comma if appropriate)
				$values .= ((strlen($values) > 0) ? ", " : "" ) . $value;
			}
			
			// Add beginning of insert statement to query string
			$queryString = "INSERT INTO " . $tableName;
			// Add names of columns and their values to query string
			$queryString .= " (" . $keys . ") VALUES (" . $values . ")";
			// Add query ending to query string
			$queryString .= ";";

			// Execute query and return result 
			return Query($queryString);
		}
		
		// Select Rows from Specified Table in Accordance to Specified Filters (Column Names and Values) and Columns to Select
		public function Select($tableName, $filters, $columns = null, $joins = null)
		{
			// Build up columns list string
			$columns = empty($columns) ? "*" : "`" . $tableName . "`" . "." . "`" . implode("`" . ", ". "`" . $tableName . "`" . "." . "`", $columns). "`";
			// Initialize beginning of select statement to query string (SELECT statement, columns names, FROM statement and table name)
			$queryString = "SELECT " . $columns . " FROM " . "`" . $tableName . "`";
			
			// Check if joins array is not empty (is not null and contain some elements)
			if(!empty($joins))
			{
				// For each join in joins array
				foreach($joins as $join => $joinfield)
				{
					// Replace join id field to required field from joined table
					$queryString = str_replace("`" . $tableName . "`" . "." . "`" . $join . "`", "`" . $join . "`" . "." . "`" . $joinfield . "`" . " AS " . "`" . $join . "`", $queryString);
					// Add INNER JOIN statement using provided join field name
					$queryString .= " INNER JOIN " . "`" . $join . "`" . " ON " . "`" . $tableName . "`" . "." . "`" . $join . "`" . "=" . "`" . $join . "`" . "." . "`id`";
				}
			}
			
			// Check if filters array is not empty (is not null and contain some elements)
			if(!empty($filters))
			{
				// Attach WHERE statement to the query string
				$queryString .= " WHERE";
				// Filter filters array (remove nulls)
				$filters = array_filter($filters);
				// Initialize filters counter
				$counter = 0;
				
				// For each filter in filters array
				foreach(array_keys($filters) as $column)
				{
					// Attach filter statement to the query string (if there are other conditions, combine them using AND statement)
					$queryString .= (($counter > 0) ? " AND " : " ") . $column . "=?";
					// Increment filters counter
					$counter++;
				}
			}
			// Attach query ending to query string
			$queryString .= ";";
			
			// Prepare statement
			$statement = $this->connection->prepare($queryString);
			// Check if statement is not correct
			if(!$statement)
			{
				// Operation fail
				return false;
			}
			
			// Bind statement parameters
			$this->BindStatementParameters($statement, $filters);
			// Execute query and return result
			return $this->Execute($statement);
		}
		
		// Bind Statement Parameters to Provided Statement using Specified Filters
		protected function BindStatementParameters($statement, $filters)
		{
			// Get parameters types string based on filters array
			$parameterTypes = $this->GetBindStatementParameterTypes($filters);
			// Initialize empty bind parameters array for bind_param() function
			$bindParameters = array();
			
			// Attach parameter types string to bindParameters array
			$bindParameters[] = &$parameterTypes;
			// For each filter in filters array
			foreach($filters as $filter)
			{
			  // Attach filter values to bindParameters array by reference
			  $bindParameters[] = &$filter;
			}
			 
			// Use call_user_func_array to call bind_param function using bind parameters array
			call_user_func_array(array($statement, 'bind_param'), $bindParameters);
		}
		
		// Get parameters types string based on filters array
		protected function GetBindStatementParameterTypes($filters)
		{
			// Initialize empty parameter types string
			$parameterTypes = '';
			
			// For each filter in filters array
			foreach($filters as $filter)
			{
				// Attach bind parameter type letter based on filter type
				switch(gettype($filter))
				{
					// In case of boolean/integer attach 'i'
					case "boolean":
					case "integer":
						$parameterTypes .= 'i';
						break;
					// In case of double/float attach 'd'
					case "double":
						$parameterTypes .= 'd';
						break;
					// In case of string attach 's'
					case "string":
						$parameterTypes .= 's';
						break;
					// In other cases attach 'b' (blob)
					default:
						$parameterTypes .= 'b';
						break;
				}
			}
			
			// Return parameter types string
			return $parameterTypes;
		}
		
		// Execute Provided MySQLi Statement and Get the Result
		protected function Execute($statement)
		{
			// Initialize whole result array
			$result = array();
			
			// Execute query and return result 
			$statement->execute();
			// Get execution result from statement
			$statementResult = $statement->get_result();
			
			// Fetch statement result to array
			while ($row = $statementResult->fetch_array(MYSQLI_ASSOC))
			{
				// Add row result to whole result array
				$result[] = $row;
			}
			
			// Free resources
			$statement->free_result();
			// Return result
			return $result;
		}
		
		// Update Row into Specified Table using Key-Value Pairs
		public function Update($tableName, $id, $values)
		{
			// Initialize sets string
			$sets = "";
			
			// For each set in sets array
			foreach ($values as $key => $value)
			{
				// Add set to sets string (and comma if appropriate)
				$sets .= ((strlen($sets) > 0) ? ", " : "" ) . $key . "='" . $value . "'";
			}
			
			// Add beginning of update statement to query string
			$queryString = "UPDATE " . $tableName;
			// Add sets to query string
			$queryString .= " SET " . $sets;
			// Add id condition to query string 
			$queryString .= " WHERE id = '" . $id . "'";
			// Add query ending to query string
			$queryString .= ";";
			
			// Execute query and return result 
			return $this->Query($queryString);
		}
		
		// Delete Rows from Specified Table by ID
		public function Delete($tableName, $id)
		{
			// Add beginning of delete statement to query string
			$queryString = "DELETE FROM " . $tableName;
			// Add id condition to query string 
			$queryString .= " WHERE 'id' = " . $id;
			// Add query ending to query string
			$queryString .= ";";
			
			// Execute query and return result 
			return Query($queryString);
		}
		
		// Advanced code for future development
	
		/*
		protected $_dbHandle;
		protected $_result;
		protected $_query;
		protected $_table;

		protected $_describe = array();

		protected $_orderBy;
		protected $_order;
		protected $_extraConditions;
		protected $_hO;
		protected $_hM;
		protected $_hMABTM;
		protected $_page;
		protected $_limit;

		// Select Query

		function where($field, $value)
		{
			$this->_extraConditions .= '`'.$this->_model.'`.`'.$field.'` = \''.mysql_real_escape_string($value).'\' AND ';
		}

		function like($field, $value)
		{
			$this->_extraConditions .= '`'.$this->_model.'`.`'.$field.'` LIKE \'%'.mysql_real_escape_string($value).'%\' AND ';
		}

		function showHasOne()
		{
			$this->_hO = 1;
		}

		function showHasMany()
		{
			$this->_hM = 1;
		}

		function showHMABTM()
		{
			$this->_hMABTM = 1;
		}

		function setLimit($limit)
		{
			$this->_limit = $limit;
		}

		function setPage($page)
		{
			$this->_page = $page;
		}

		function orderBy($orderBy, $order = 'ASC')
		{
			$this->_orderBy = $orderBy;
			$this->_order = $order;
		}

		function search()
		{
			global $inflect;

			$from = '`'.$this->_table.'` as `'.$this->_model.'` ';
			$conditions = '\'1\'=\'1\' AND ';
			$conditionsChild = '';
			$fromChild = '';

			if ($this->_hO == 1 && isset($this->hasOne))
			{	
				foreach ($this->hasOne as $alias => $model)
				{
					$table = strtolower($inflect->pluralize($model));
					$singularAlias = strtolower($alias);
					$from .= 'LEFT JOIN `'.$table.'` as `'.$alias.'` ';
					$from .= 'ON `'.$this->_model.'`.`'.$singularAlias.'_id` = `'.$alias.'`.`id`  ';
				}
			}
		
			if ($this->id)
			{
				$conditions .= '`'.$this->_model.'`.`id` = \''.mysql_real_escape_string($this->id).'\' AND ';
			}

			if ($this->_extraConditions)
			{
				$conditions .= $this->_extraConditions;
			}

			$conditions = substr($conditions,0,-4);
			
			if (isset($this->_orderBy))
			{
				$conditions .= ' ORDER BY `'.$this->_model.'`.`'.$this->_orderBy.'` '.$this->_order;
			}

			if (isset($this->_page))
			{
				$offset = ($this->_page-1)*$this->_limit;
				$conditions .= ' LIMIT '.$this->_limit.' OFFSET '.$offset;
			}
			
			$this->_query = 'SELECT * FROM '.$from.' WHERE '.$conditions;
			$this->_result = mysql_query($this->_query, $this->_dbHandle);
			$result = array();
			$table = array();
			$field = array();
			$tempResults = array();
			$numOfFields = mysql_num_fields($this->_result);
			
			for ($i = 0; $i < $numOfFields; ++$i)
			{
				array_push($table,mysql_field_table($this->_result, $i));
				array_push($field,mysql_field_name($this->_result, $i));
			}
			
			if (mysql_num_rows($this->_result) > 0 )
			{
				while ($row = mysql_fetch_row($this->_result))
				{
					for ($i = 0;$i < $numOfFields; ++$i)
					{
						$tempResults[$table[$i]][$field[$i]] = $row[$i];
					}

					if ($this->_hM == 1 && isset($this->hasMany))
					{
						foreach ($this->hasMany as $aliasChild => $modelChild)
						{
							$queryChild = '';
							$conditionsChild = '';
							$fromChild = '';

							$tableChild = strtolower($inflect->pluralize($modelChild));
							$pluralAliasChild = strtolower($inflect->pluralize($aliasChild));
							$singularAliasChild = strtolower($aliasChild);

							$fromChild .= '`'.$tableChild.'` as `'.$aliasChild.'`';
							
							$conditionsChild .= '`'.$aliasChild.'`.`'.strtolower($this->_model).'_id` = \''.$tempResults[$this->_model]['id'].'\'';
		
							$queryChild =  'SELECT * FROM '.$fromChild.' WHERE '.$conditionsChild;	
							$resultChild = mysql_query($queryChild, $this->_dbHandle);
					
							$tableChild = array();
							$fieldChild = array();
							$tempResultsChild = array();
							$resultsChild = array();
							
							if (mysql_num_rows($resultChild) > 0)
							{
								$numOfFieldsChild = mysql_num_fields($resultChild);
								
								for ($j = 0; $j < $numOfFieldsChild; ++$j)
								{
									array_push($tableChild,mysql_field_table($resultChild, $j));
									array_push($fieldChild,mysql_field_name($resultChild, $j));
								}

								while ($rowChild = mysql_fetch_row($resultChild))
								{
									for ($j = 0;$j < $numOfFieldsChild; ++$j)
									{
										$tempResultsChild[$tableChild[$j]][$fieldChild[$j]] = $rowChild[$j];
									}
									
									array_push($resultsChild,$tempResultsChild);
								}
							}
							
							$tempResults[$aliasChild] = $resultsChild;
							
							mysql_free_result($resultChild);
						}
					}

					if ($this->_hMABTM == 1 && isset($this->hasManyAndBelongsToMany))
					{
						foreach ($this->hasManyAndBelongsToMany as $aliasChild => $tableChild)
						{
							$queryChild = '';
							$conditionsChild = '';
							$fromChild = '';

							$tableChild = strtolower($inflect->pluralize($tableChild));
							$pluralAliasChild = strtolower($inflect->pluralize($aliasChild));
							$singularAliasChild = strtolower($aliasChild);

							$sortTables = array($this->_table,$pluralAliasChild);
							sort($sortTables);
							$joinTable = implode('_',$sortTables);

							$fromChild .= '`'.$tableChild.'` as `'.$aliasChild.'`,';
							$fromChild .= '`'.$joinTable.'`,';
							
							$conditionsChild .= '`'.$joinTable.'`.`'.$singularAliasChild.'_id` = `'.$aliasChild.'`.`id` AND ';
							$conditionsChild .= '`'.$joinTable.'`.`'.strtolower($this->_model).'_id` = \''.$tempResults[$this->_model]['id'].'\'';
							$fromChild = substr($fromChild,0,-1);

							$queryChild =  'SELECT * FROM '.$fromChild.' WHERE '.$conditionsChild;	
							$resultChild = mysql_query($queryChild, $this->_dbHandle);
					
							$tableChild = array();
							$fieldChild = array();
							$tempResultsChild = array();
							$resultsChild = array();
							
							if (mysql_num_rows($resultChild) > 0)
							{
								$numOfFieldsChild = mysql_num_fields($resultChild);
								
								for ($j = 0; $j < $numOfFieldsChild; ++$j)
								{
									array_push($tableChild,mysql_field_table($resultChild, $j));
									array_push($fieldChild,mysql_field_name($resultChild, $j));
								}

								while ($rowChild = mysql_fetch_row($resultChild))
								{
									for ($j = 0;$j < $numOfFieldsChild; ++$j)
									{
										$tempResultsChild[$tableChild[$j]][$fieldChild[$j]] = $rowChild[$j];
									}
									
									array_push($resultsChild,$tempResultsChild);
								}
							}
							
							$tempResults[$aliasChild] = $resultsChild;
							mysql_free_result($resultChild);
						}
					}

					array_push($result,$tempResults);
				}

				if (mysql_num_rows($this->_result) == 1 && $this->id != null)
				{
					mysql_free_result($this->_result);
					$this->clear();
					return($result[0]);
				}
				else
				{
					mysql_free_result($this->_result);
					$this->clear();
					return($result);
				}
			}
			else
			{
				mysql_free_result($this->_result);
				$this->clear();
				return $result;
			}
		}

		// Custom SQL Query
		
		function custom($query)
		{
			global $inflect;

			$this->_result = mysql_query($query, $this->_dbHandle);

			$result = array();
			$table = array();
			$field = array();
			$tempResults = array();

			if(substr_count(strtoupper($query),"SELECT")>0)
			{
				if (mysql_num_rows($this->_result) > 0)
				{
					$numOfFields = mysql_num_fields($this->_result);
					
					for ($i = 0; $i < $numOfFields; ++$i)
					{
						array_push($table,mysql_field_table($this->_result, $i));
						array_push($field,mysql_field_name($this->_result, $i));
					}
					
					while ($row = mysql_fetch_row($this->_result))
					{
						for ($i = 0;$i < $numOfFields; ++$i)
						{
							$table[$i] = ucfirst($inflect->singularize($table[$i]));
							$tempResults[$table[$i]][$field[$i]] = $row[$i];
						}
						
						array_push($result,$tempResults);
					}
				}
				
				mysql_free_result($this->_result);
			}
			
			$this->clear();
			return($result);
		}

		// Describes a Table
		protected function _describe()
		{
			global $cache;

			$this->_describe = $cache->get('describe'.$this->_table);

			if (!$this->_describe)
			{
				$this->_describe = array();
				$query = 'DESCRIBE '.$this->_table;
				$this->_result = mysql_query($query, $this->_dbHandle);
				
				while ($row = mysql_fetch_row($this->_result))
				{
					 array_push($this->_describe,$row[0]);
				}

				mysql_free_result($this->_result);
				$cache->set('describe'.$this->_table,$this->_describe);
			}

			foreach ($this->_describe as $field)
			{
				$this->$field = null;
			}
		}

		// Delete an Object

		function delete()
		{
			if ($this->id)
			{
				$query = 'DELETE FROM ' . $this->_table . ' WHERE `id`=\'' . mysql_real_escape_string($this->id) . '\'';		
				$this->_result = mysql_query($query, $this->_dbHandle);
				$this->clear();
				
				if ($this->_result == 0)
				{
					// Error Generation
					return -1;
				}
			}
			else
			{
				// Error Generation
				return -1;
			}
		}

		// Saves an Object i.e. Updates/Inserts Query

		function save()
		{
			$query = '';
			
			if (isset($this->id))
			{
				$updates = '';
				
				foreach ($this->_describe as $field)
				{
					if ($this->$field)
					{
						$updates .= '`'.$field.'` = \''.mysql_real_escape_string($this->$field).'\',';
					}
				}

				$updates = substr($updates,0,-1);

				$query = 'UPDATE '.$this->_table.' SET '.$updates.' WHERE `id`=\''.mysql_real_escape_string($this->id).'\'';			
			}
			else
			{
				$fields = '';
				$values = '';
				
				foreach ($this->_describe as $field)
				{
					if ($this->$field)
					{
						$fields .= '`'.$field.'`,';
						$values .= '\''.mysql_real_escape_string($this->$field).'\',';
					}
				}
				
				$values = substr($values,0,-1);
				$fields = substr($fields,0,-1);

				$query = 'INSERT INTO '.$this->_table.' ('.$fields.') VALUES ('.$values.')';
			}
			
			$this->_result = mysql_query($query, $this->_dbHandle);
			$this->clear();
			
			if ($this->_result == 0)
			{
				// Error Generation
				return -1;
			}
		}
	 
		// Clear All Variables

		function clear()
		{
			foreach($this->_describe as $field)
			{
				$this->$field = null;
			}

			$this->_orderby = null;
			$this->_extraConditions = null;
			$this->_hO = null;
			$this->_hM = null;
			$this->_hMABTM = null;
			$this->_page = null;
			$this->_order = null;
		}

		// Pagination Count

		function totalPages()
		{
			if ($this->_query && $this->_limit)
			{
				$pattern = '/SELECT (.*?) FROM (.*)LIMIT(.*)/i';
				$replacement = 'SELECT COUNT(*) FROM $2';
				$countQuery = preg_replace($pattern, $replacement, $this->_query);
				$this->_result = mysql_query($countQuery, $this->_dbHandle);
				$count = mysql_fetch_row($this->_result);
				$totalPages = ceil($count[0]/$this->_limit);
				return $totalPages;
			}
			else
			{
				// Error Generation Code Here
				return -1;
			}
		}

		// Get error string

		function getError()
		{
			return mysql_error($this->_dbHandle);
		}
		*/
	}