<?php
    class Category{

        // DB Stuff
        private $conn;
        private $table= 'categories';

        public $id;
        public $name;
        public $created_at;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = 'SELECT 
                id,
                name,
                created_at
            FROM
                '. $this->table . ' 
            ORDER BY
                created_at DESC'; 
            
            printf($query);
        
            
            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        public function readSingle(){
            $query = 'SELECT 
                id, 
                name,
                created_at
            FROM 
                ' . $this->table . ' 
            WHERE 
                id = :id';

            $stmt = $this->conn->prepare($query);
            $stmt->execute(['id' => $this->id]);

            $row =  $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->created_at = $row['created_at'];

            return $stmt;
        }
        
        public function create() {
            $query = 'INSERT INTO 
                ' . $this->table . '
            SET
                name = :name';

            $stmt = $this->conn->prepare($query);

            $this->name = htmlspecialchars(strip_tags($this->name));
            
            if($stmt->execute([
                'name' => $this->name])){

                return true;
            }

            printf("Error: %s \n", $stmt->error);
            return false;
        }

        public function update()
        {
            $query = 'UPDATE 
                ' . $this->table . ' 
            SET
                name = :name
            WHERE
                id = :id';

            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->name = htmlspecialchars(strip_tags($this->name));

            if($stmt->execute([
                'name' => $this->name,
                'id' => $this->id])){
                return true;
            }else {
                printf("Error %s \n", $stmt->error);
                return false;
            }
        }

        public function delete()
        {
            $query = 'DELETE FROM
                '. $this->table . ' 
            WHERE
                id = :id';

            $stmt = $this->conn->prepare($query);

            $this->id = htmlspecialchars(strip_tags($this->id));

            if($stmt->execute([
                'id' => $this->id])){
                return true;
            }else {
                printf('Error: %s \n', $stmt->error);
                return false;
            }
        } 
    }