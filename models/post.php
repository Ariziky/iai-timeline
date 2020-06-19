<?php
  class Post {

    // DB stuff
    private $conn;
    private $table = 'posts';

    // Post Properties
    public $id;
    public $category;
    public $title;
    public $body;
    public $author_id;
    public $author_name;
    public $author_photo_url;
    public $response_to;
    public $nb_responses;
    public $created_at;
    public $color;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Publications
    public function read() {
      // Create query
      $query = "SELECT *
                    FROM " . $this->table . "
                    WHERE category != 'NULL'
                    ORDER BY created_at DESC";

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }





    // Get Single Post id
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

          switch($row['category']) {
              case 'Questions':
                  $color = '#F1592A';
                  break;
              case 'Vitrines':
                   $color = '#3AB54A';
                   break;
              case 'Annonces':
                   $color = '#8C6238';
                   break;
              case 'Emplois':
                   $color = '#25AAE2';
                   break;
              case 'Stages':
                   $color = '#F7941D';
                   break;
            }

          // Set properties
          $this->id = $row['id'];
          $this->category = $row['category'];
          $this->title = ucfirst($row['title']);
          $this->body = $row['body'];
          $this->author_id = $row['author_id'];
          $this->author_name = $row['author_name'];
          $this->author_photo_url = $row['author_photo_url'];
          $this->response_to = $row['response_to'];
          $this->nb_responses = $row['nb_responses'];
          $this->created_at = $this->ago($row['created_at']);
          $this->color = $color;

    }



    // Get Single Post responses
        public function read_responses() {
          // Create query
          $query = 'SELECT p2.id, p2.body, p2.response_to, p2.author_name, p2.author_photo_url, p2.created_at
                        FROM ' . $this->table . ' p1, ' . $this->table . ' p2
                        WHERE p1.id = ? AND p2.response_to = ?' ;

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->response_to);
          $stmt->bindParam(2, $this->response_to);

          // Execute query
          $result = $stmt->execute();

          return $stmt;
        }


    // Create Post
    public function create() {
          // create query
          $query = 'INSERT INTO ' . $this->table . ' SET category = :category, title = :title, body = :body, author_id = :author_id, author_name = :author_name, author_photo_url = :author_photo_url, response_to = :response_to, nb_responses = :nb_responses';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->title = htmlspecialchars(strip_tags($this->title));
          $this->title = htmlspecialchars(strip_tags($this->body));

          // Bind data
          $stmt->bindParam(':category', $this->category);
          $stmt->bindParam(':title', $this->title);
          $stmt->bindParam(':body', $this->body);
          $stmt->bindParam(':author_id', $this->author_id);
          $stmt->bindParam(':author_name', $this->author_name);
          $stmt->bindParam(':author_photo_url', $this->author_photo_url);
          $stmt->bindParam(':response_to', $this->response_to);
          $stmt->bindParam(':nb_responses', $this->nb_responses);

          // Execute query
          if($stmt->execute()) {
              return true;
          }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }


    function pluralize($count, $text)
    {
        return $count . " $text";
    }

    function ago($datetime)
    {
        date_default_timezone_set('Europe/Paris');
        $interval = date_create('now')->diff(date_create($datetime));
        //$suffix = ( $interval->invert ? ' ago' : '' );
        if ( $v = $interval->y >= 1 ) return $this->pluralize( $interval->y, 'y' );
        if ( $v = $interval->m >= 1 ) return $this->pluralize( $interval->m, 'mon' );
        if ( $v = $interval->d >= 1 ) return $this->pluralize( $interval->d, 'd' );
        if ( $v = $interval->h >= 1 ) return $this->pluralize( $interval->h, 'h' );
        if ( $v = $interval->i >= 1 ) return $this->pluralize( $interval->i, 'min' );
        return $this->pluralize( $interval->s, 's' );
    }


  }
