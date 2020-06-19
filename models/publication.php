<?php
  class Publication {

    // DB stuff
    private $conn;
    private $table = 'publication';

    // Post Properties
    public $id;
    public $title;
    public $image;
    public $date;
    public $user_id;
    public $user_name;
    public $user_photo_profile;
    public $nb_likes;
    public $nb_comments;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Publications
    public function read() {
      // Create query
      $query = 'SELECT *
                    FROM ' . $this->table . '
                    ORDER BY date DESC';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }


    // Get Single Publication' nb_likes by id
    public function read_single() {
      // Create query
      $query = 'SELECT *
                    FROM ' . $this->table . '
                    WHERE id = ?
                    LIMIT 0,1';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      $result = $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          $date = date_format(date_create($row['date']), 'd/m/y \à\ H:i:s');

          // Set properties
          $this->id = $row['id'];
          $this->title = ucfirst($row['title']);
          $this->image = $row['image'];
          $this->date = $date;
          $this->user_id = $row['user_id'];
          $this->user_name = $row['user_name'];
          $this->user_photo_profile = $row['user_photo_profile'];
          $this->nb_likes = $row['nb_likes'];
          $this->nb_comments = $row['nb_comments'];
    }


    // Create Publication
    public function create() {
          // create query
          $query = 'INSERT INTO ' . $this->table . ' SET title = :title, image = :image, user_id = :user_id, user_name = :user_name, user_photo_profile = :user_photo_profile, nb_likes = :nb_likes, nb_comments = :nb_comments';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->title = htmlspecialchars(strip_tags($this->title));

          // Bind data
          $stmt->bindParam(':title', $this->title);
          $stmt->bindParam(':image', $this->image);
          $stmt->bindParam(':user_id', $this->user_id);
          $stmt->bindParam(':user_name', $this->user_name);
          $stmt->bindParam(':user_photo_profile', $this->user_photo_profile);
          $stmt->bindParam(':nb_likes', $this->nb_likes);
          $stmt->bindParam(':nb_comments', $this->nb_comments);

          // Execute query
          if($stmt->execute()) {
              return true;
          }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

  }
