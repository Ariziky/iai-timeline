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

  // Check if any posts
  $comment->publication_id = isset($_POST['v_publication_id']) ? $_POST['v_publication_id'] : NULL;
  $comment->user_id = isset($_POST['v_user_id']) ? $_POST['v_user_id'] : NULL;

  if($comment->delete()) {
    $comment->decommenter();
  }

  echo json_encode($comment);
?>
