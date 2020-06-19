<?php
  class Like {

    // DB stuff
    private $conn;
    private $table = 'likes';

    // Post Properties
    public $id;
    public $publication_id;
    public $user_id;


    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get All publication's likes
    public function getAll() {
      // Create query
      $query = 'SELECT *
                    FROM ' . $this->table . '
                    WHERE publication_id = ? ';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind publication_id
      $stmt->bindParam(1, $this->publication_id);

      // Execute query
      $stmt->execute();

      return $stmt;
    }


    // Get like by publication_id and user_id
    public function read_single() {
      // Create query
      $query = 'SELECT *
                    FROM ' . $this->table . '
                    WHERE publication_id = ? AND user_id = ?
                    LIMIT 0,1';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind user_id
      $stmt->bindParam(1, $this->publication_id);
      $stmt->bindParam(2, $this->user_id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Set properties
      $this->id = $row['id'];
      $this->publication_id = $row['publication_id'];
      $this->user_id = $row['user_id'];

    }


    // Create Publication
    public function create() {
          // create query
          $query = 'INSERT INTO ' . $this->table . ' SET publication_id = :publication_id, user_id = :user_id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind data
          $stmt->bindParam(':publication_id', $this->publication_id);
          $stmt->bindParam(':user_id', $this->user_id);

          // Execute query
          if($stmt->execute()) {
              return true;
          }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }


    // Update Post
        public function likes() {
              // Create query
              $query = 'UPDATE `publication` SET `nb_likes`= (`nb_likes` + 1) WHERE id = ?';

              // Prepare statement
              $stmt = $this->conn->prepare($query);

              // Bind data
              $stmt->bindParam(1, $this->publication_id);

              // Execute query
              if($stmt->execute()) {
                return true;
              }

              // Print error if something goes wrong
              printf("Error: %s.\n", $stmt->error);

              return false;
        }


        // Update Post
        public function dislikes() {
              // Create query
              $query = 'UPDATE `publication` SET `nb_likes`= (`nb_likes` - 1) WHERE id = ?';

              // Prepare statement
              $stmt = $this->conn->prepare($query);

              // Bind data
              $stmt->bindParam(1, $this->publication_id);

              // Execute query
              if($stmt->execute()) {
                return true;
              }

              // Print error if something goes wrong
              printf("Error: %s.\n", $stmt->error);

              return false;
        }

        // Delete Like
        public function delete() {
              // Delete query
              $query = 'DELETE FROM ' . $this->table . ' WHERE publication_id = ? AND user_id = ?';

              // Prepare statement
              $stmt = $this->conn->prepare($query);

              // Bind data
              $stmt->bindParam(1, $this->publication_id);
              $stmt->bindParam(2, $this->user_id);

              // Execute query
              if($stmt->execute()) {
                return true;
              }

              // Print error if something goes wrong
              printf("Error: %s.\n", $stmt->error);

              return false;
        }

  }
