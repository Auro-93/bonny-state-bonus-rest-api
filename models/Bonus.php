<?php

class Bonus
	{
	private $conn;
	private $table_name = "bonus_list";
    private $join_table = "bonus_type";

	public $id;
	public $name;
	public $type_id;
    public $quantity;
    public $sold_at;

	public function __construct($db)
		{
		$this->conn = $db;
		}


	// READ 
	public function read(array $params){

        $category = htmlspecialchars(strip_tags($params["category"]), ENT_NOQUOTES);
        $from_date = htmlspecialchars(strip_tags($params["from_date"]), ENT_NOQUOTES);
        $to_date = htmlspecialchars(strip_tags($params["to_date"]), ENT_NOQUOTES);

       $wheres = array();
   

       if(!empty($category)){
        $wheres[] ="b.type = $category";
       }
       if(!empty($from_date)){
        $wheres[] ="a.sold_at >= $from_date";
       }
       if(!empty($to_date)){
        $wheres[] ="a.sold_at <= $to_date";
       }



       $query = "SELECT a.id, a.name, b.type, a.quantity, a.sold_at FROM $this->table_name a INNER JOIN $this->join_table b ON a.type_id = b.id";
       if(!empty($wheres)){
           $query .= " WHERE " . implode(" AND ",  $wheres); 
       }

       $query .= " ORDER BY a.sold_at DESC";
  
        
        $stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
		
    }

    public function create(){
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, type_id=:type_id, quantity = :quantity, sold_at = :sold_at;
            ";


        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->type_id = htmlspecialchars(strip_tags($this->type_id));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->sold_at = htmlspecialchars(strip_tags($this->sold_at));

        // binding
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":type_id", $this->type_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":sold_at", $this->sold_at);

        if($stmt->execute()){
            return true;
        }
        return false; 
    }

    public function update(){
        
        $query = "UPDATE
        " . $this->table_name . "
        SET
            name = :name,
            type_id = :type_id,
            quantity = :quantity,
            sold_at = :sold_at
        WHERE
            id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->type_id = htmlspecialchars(strip_tags($this->type_id));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->sold_at = htmlspecialchars(strip_tags($this->sold_at));

        // binding
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":type_id", $this->type_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":sold_at", $this->sold_at);

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
		

	}
