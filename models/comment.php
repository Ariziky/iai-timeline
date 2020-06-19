<?php
  class Comment {

    // DB stuff
    private $conn;
    private $table = 'comments';

    // Post Properties
    public $id;
    public $contenu;
    public $publication_id;
    public $user_id;
    public $user_name;
    public $user_photo_url;
    public $created_at;
    public $updated_at;


    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }


    // Get Comments by publication_id
    public function read() {
      // Create query
      $query = 'SELECT *
                    FROM ' . $this->table . '
                    WHERE publication_id =  ?
                    ORDER BY created_at DESC';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(1, $this->publication_id);

      // Execute query
      $stmt->execute();

      return $stmt;
    }


    // Get comment by publication_id and user_id
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
          $this->contenu = $row['contenu'];
          $this->publication_id = $row['publication_id'];
          $this->user_id = $row['user_id'];
          $this->user_name = $row['user_name'];
          $this->user_photo_url = $row['user_photo_url'];
          $this->created_at = $row['created_at'];
          $this->updated_at = $row['updated_at'];

        }

    // Get Comments by pub_id and user_id
        public function readByPubAndUser() {
          // Create query
          $query = 'SELECT *
                        FROM ' . $this->table . '
                        WHERE publication_id = ? AND user_id = ?';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          $stmt->bindParam(1, $this->publication_id);
          $stmt->bindParam(2, $this->user_id);

          // Execute query
          $stmt->execute();

          return $stmt;
        }


    // Create Comment
    public function create() {
          // create query
          $query = 'INSERT INTO ' . $this->table . ' SET contenu = :contenu, publication_id = :publication_id, user_id = :user_id, user_name = :user_name, user_photo_url = :user_photo_url';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind data
          $stmt->bindParam(':contenu', $this->contenu);
          $stmt->bindParam(':publication_id', $this->publication_id);
          $stmt->bindParam(':user_id', $this->user_id);
          $stmt->bindParam(':user_name', $this->user_name);
          $stmt->bindParam(':user_photo_url', $this->user_photo_url);

          // Execute query
          if($stmt->execute()) {
              return true;
          }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }


    // Update Post
        public function commenter() {
              // Create query
              $query = 'UPDATE `publication` SET `nb_comments`= (`nb_comments` + 1) WHERE id = ?';

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
        public function decommenter() {
              // Create query
              $query = 'UPDATE `publication` SET `nb_comments`= (`nb_comments` - 1) WHERE id = ?';

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

        // Delete comment
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
