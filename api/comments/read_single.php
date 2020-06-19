<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/comment.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate publication object
  $comment = new Comment($db);

  $comment->publication_id = isset($_GET['v_publication_id']) ? $_GET['v_publication_id'] : NULL;
  $comment->user_id = isset($_GET['v_user_id']) ? $_GET['v_user_id'] : NULL;

  // comment query
  $result = $comment->read_single();

  echo json_encode($comment);

?>
