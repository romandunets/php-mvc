<?php
	
	// Abstract SQL Model Class
	abstract class SQLModel extends Model
    {
		// SQL Object Instance
		protected $sql;
		// Model Table Name
		protected $table;
		
		// Create and Initialize Model
		public function __construct($table = null, SQL $sql = null)
        {
			// Check if table is not null
			if($table != null)
			{
				// Set specified table as current
				$this->table = $table;
			}
			else
			{
				// Set class name as table name
				$this->table = strtolower(str_replace(MODEL_CLASS_SUFFIX, '', get_class($this)));
			}
			
			// Check if SQL is not null
			if($sql != null)
			{
				// Set specified SQL instance as current
				$this->sql = $sql;
			}
			else
			{
				// Initialize new SQL instance
				$this->sql = new SQL();
				// Connect to database using SQL instance
				$this->sql->Connect();
			}
        }
		
		// Get Current Table Name
		public function GetTable()
		{
			return $this->table;
		}
		
		// Get Current SQL Instance
		public function GetSQL()
		{
			return $this->sql;
		}
		
		// Create (Insert) Entity (as Array) into Table
		public function Create(array $entity)
		{
			return $this->sql->Insert($this->table, $entity);
		}
		
		// Read Entities from Table Based on Filters Array
		public function Read($filters)
		{
			return $this->sql->Select($this->table, $filters);
		}
		
		// Update Entity (as Array using ID) in Table
		public function Update($id, array $entity)
		{
			return $this->sql->Update($this->table, $id, $entity);
		}
		
		// Delete Entity (using ID) from Table
		public function Delete($id)
		{
			return $this->sql->Delete($this->table, $id);
		}
    }