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
  $post = new Post($db);

  $post->id = isset($_GET['v_post_id']) ? $_GET['v_post_id'] : NULL;

  // post query
  $result = $post->read_single();

  echo json_encode($post);


?>
