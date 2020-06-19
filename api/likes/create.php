<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/like.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate like object
  $like = new Like($db);

  // Check if any posts
  $like->publication_id = isset($_POST['v_publication_id']) ? $_POST['v_publication_id'] : NULL;
  $like->user_id = isset($_POST['v_user_id']) ? $_POST['v_user_id'] : NULL;

  if($like->create()) {
    $like->likes();
  }

  echo json_encode($like);
?>
