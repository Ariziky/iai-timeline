<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  //header('Cache-Control: no-cache');

  include_once '../../config/database.php';
  include_once '../../models/publication.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate publication object
  $publication = new Publication($db);

  // Check if any posts
  $publication->title = isset($_POST['v_title']) ? $_POST['v_title'] : NULL;
  $publication->user_id = isset($_POST['v_user_id']) ? $_POST['v_user_id'] : NULL;
  $publication->user_name = isset($_POST['v_username']) ? $_POST['v_username'] : NULL;
  $publication->user_photo_profile = isset($_POST['v_user_photo_profile']) ? $_POST['v_user_photo_profile'] : NULL;
  //$camera = isset($_POST['v_camera']) ? $_POST['v_camera'] : NULL;;

  //if ($camera == 0) {
  if (isset($_FILES['v_image'])) {
      $path = $_FILES['v_image']['tmp_name'];
      $type = pathinfo($path, PATHINFO_EXTENSION);
      $data = file_get_contents($path);
      $image_base64 = base64_encode($data);
      $publication->image = 'data:image/'.$type.';base64,'.$image_base64;
  } else {
        $publication->image = NULL;
  }
  /*}
  else {
      $publication->image = $_POST['v_image'];
  }*/

  $publication->nb_likes = 0;
  $publication->nb_comments = 0;

  $publication->create();

  echo json_encode($publication);
?>
