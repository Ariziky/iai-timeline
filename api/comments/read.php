<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/comment.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate comment object
  $comment = new Comment($db);

  $comment->publication_id = isset($_GET['v_publication_id']) ? $_GET['v_publication_id'] : NULL;

  // comment query
  $result = $comment->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any comment
  if($num > 0) {
    // comment array
    $comments_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $comment = array(
        'id' => $id,
        'contenu' => ucfirst($contenu),
        'publication_id' => $publication_id,
        'user_id' => $user_id,
        'user_name' => $user_name,
        'user_photo_url' => $user_photo_url,
        'created_at' => $created_at,
        'updated_at' => $updated_at
      );

      // Push to "data"
      array_push($comments_arr, $comment);
    }

    // Turn to JSON & output
    echo json_encode($comments_arr);

  } else {
    // No comment
    echo json_encode(
      array('message' => 'Aucun commentaire trouvé !')
    );
  }
