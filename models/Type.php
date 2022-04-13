<?php

class Type
	{
	private $conn;
	private $table_name = "bonus_type";

	public $id;
	public $type;
	public $saved_minutes;
   

	public function __construct($db)
		{
		$this->conn = $db;
		}


	// READ 
	public function read(){

       $query = "SELECT * FROM $this->table_name";
    
        $stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
		
    }

    public function create(){
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                type=:type, saved_minutes = :saved_minutes;
            ";


        $stmt = $this->conn->prepare($query);

        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->saved_minutes = htmlspecialchars(strip_tags($this->saved_minutes));
      
        // binding
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":saved_minutes", $this->saved_minutes);
  

        if($stmt->execute()){
            return true;
        }
        return false; 
    }

    public function update(){
        
        $query = "UPDATE
        " . $this->table_name . "
        SET
            type = :type,
            saved_minutes = :saved_minutes,
        WHERE
            id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->saved_minutes = htmlspecialchars(strip_tags($this->saved_minutes));

        // binding
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":saved_minutes", $this->saved_minutes);
      

        if($stmt->execute()){
            return true;
        }
        return false; 
    }

    public function delete(){

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    
    
        $stmt = $this->conn->prepare($query);
    
        $this->id = htmlspecialchars(strip_tags($this->id));
    
    
        $stmt->bindParam(1, $this->id);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    
    }
	
    
    public function read_saved_min_sum(){
        $query = "SELECT SUM(saved_minutes) AS 'total_saved_minutes' FROM $this->table_name;";

        $stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
    }

    public function read_max_saved_min(){
        $query = "SELECT 
        id,
        type,
        saved_minutes
        FROM $this->table_name
        WHERE saved_minutes = (SELECT MAX(saved_minutes) FROM $this->table_name);";

        $stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
    }

}
