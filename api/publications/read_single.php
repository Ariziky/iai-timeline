<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/publication.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate publication object
  $publication = new Publication($db);

  $publication->id = isset($_GET['v_publication_id']) ? $_GET['v_publication_id'] : NULL;

  // publication query
  $result = $publication->read_single();

  echo json_encode($publication);

?>
