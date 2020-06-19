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

  // Check if any params
  $comment->contenu = isset($_POST['v_contenu']) ? $_POST['v_contenu'] : NULL;
  $comment->publication_id = isset($_POST['v_publication_id']) ? $_POST['v_publication_id'] : NULL;
  $comment->user_id = isset($_POST['v_user_id']) ? $_POST['v_user_id'] : NULL;
  $comment->user_name = isset($_POST['v_user_name']) ? $_POST['v_user_name'] : NULL;
  $comment->user_photo_url = isset($_POST['v_user_photo_url']) ? $_POST['v_user_photo_url'] : NULL;

  if($comment->create()) {
    $comment->commenter();
  }

  echo json_encode($comment);
?>
