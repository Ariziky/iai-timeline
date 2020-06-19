<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/like.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate publication object
  $like = new Like($db);

  $like->publication_id = isset($_GET['v_publication_id']) ? $_GET['v_publication_id'] : NULL;
  $like->user_id = isset($_GET['v_user_id']) ? $_GET['v_user_id'] : NULL;


//$like->publication_id = '24';
//$like->user_id = '6k8d3CGFL1ZehP7bvc3SOxA0SJN2';

  // Like query
  $result = $like->read_single();

  echo json_encode($like);

?>
