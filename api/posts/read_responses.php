<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/post.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate post object
  $post1 = new Post($db);

  //$post1->response_to = isset($_GET['v_response_to']) ? $_GET['v_response_to'] : NULL;
  $post1->response_to = 3;

  // post query
  $result = $post1->read_responses();

     // Get row count
    $num = $result->rowCount();

    // Check if any post
    if($num > 0) {
      // post array
      $posts_arr = array();

      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $created_at = $post1->ago($created_at);

        $post = array(
          'id' => $id,
          'body' => ucwords($body),
          'author_name' => ucwords($author_name),
          'author_photo_url' => $author_photo_url,
          'response_to' => $response_to,
          'created_at' => $created_at
        );

        // Push to "data"
        array_push($posts_arr, $post);
      }

      // Turn to JSON & output
      echo json_encode($posts_arr);

    } else {
      // No Post
      echo json_encode(
        array('Aucun post trouvé !')
      );
    }


?>
