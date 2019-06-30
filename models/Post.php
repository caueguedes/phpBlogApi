<?php
    class Post {
        // DB stuff
        private $conn;
        private $table = 'posts';

        // Post properties
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;

        // Constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Posts
        public function read() {
            $query = 'SELECT c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                FROM
                    '. $this->table . ' p 
                LEFT JOIN
                    categories c ON p.category_id = c.id
                ORDER BY
                    p.created_at DESC';

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }
    

        // Get Posts
        public function readSingle() {
            $query = 'SELECT c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                FROM
                    '. $this->table . ' p 
                LEFT JOIN
                    categories c ON p.category_id = c.id
                WHERE
                    p.id = :id
                LIMIT 0,1';

            $stmt = $this->conn->prepare($query);

            // $stmt->bindParam('id', $this->id);
            $stmt->execute(['id' => $this->id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set properties
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
            return $stmt;
        }

        // Create post
        public function create(){ 

            $query = "INSERT INTO " . $this->table . '
                SET
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id';
            
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

/*
            // Bind Data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);
*/
            if($stmt->execute([
                'title' => $this->title,
                'body' => $this->body,
                'author' => $this->author,
                'category_id' => $this->category_id])){

                return true;
            }
            
            printf("Error: %s \n", $stmt->error);
            return false;
        }


        // Update post
        public function update(){ 

            $query = "UPDATE " . $this->table . '
                SET
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id
                WHERE 
                    id = :id';
            
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

/*
            // Bind Data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);
*/
            if($stmt->execute([
                'id' => $this->id,
                'title' => $this->title,
                'body' => $this->body,
                'author' => $this->author,
                'category_id' => $this->category_id])){

                return true;
            }
            
            printf("Error: %s \n", $stmt->error);
            return false;
        }    


        // De;ete post
        public function delete(){ 

            $query = "DELETE FROM " 
                    . $this->table . '
                WHERE 
                    id = :id';
            
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->id = htmlspecialchars(strip_tags($this->id));

            /*
            // Bind Data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);
*/
            if($stmt->execute([
                'id' => $this->id])){
                return true;
            }
            
            printf("Error: %s \n", $stmt->error);
            return false;
        }    
    }
