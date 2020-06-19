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

  // Check if any posts
  $post->category = isset($_POST['v_category']) ? $_POST['v_category'] : NULL;
  $post->title = isset($_POST['v_title']) ? $_POST['v_title'] : NULL;
  $post->body = isset($_POST['v_body']) ? $_POST['v_body'] : NULL;
  $post->author_id = isset($_POST['v_author_id']) ? $_POST['v_author_id'] : NULL;
  $post->author_name = isset($_POST['v_author_name']) ? $_POST['v_author_name'] : NULL;
  $post->author_photo_url = isset($_POST['v_author_photo_url']) ? $_POST['v_author_photo_url'] : NULL;
  $post->response_to = isset($_POST['v_response_to']) ? $_POST['v_response_to'] : NULL;
  $post->nb_responses = 0;

  $post->create();

  echo json_encode($post);
?>
