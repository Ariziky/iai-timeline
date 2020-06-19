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
   $publication1 = new Publication($db);

  // publication query
   $result = $publication1->read();
   // Get row count
  $num = $result->rowCount();

  // Check if any publication
  if($num > 0) {
    // publication array
    $publications_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      //$date = date_format(date_create($date), 'l \a\t g:i A');
      $date = date_format(date_create($date), 'd/m/y \à\ H:i:s');

      $publication = array(
        'id' => $id,
        'title' => ucfirst($title),
        'image' => $image,
        'date' => $date,
        'user_id' => $user_id,
        'user_name' => ucfirst($user_name),
        'user_photo_profile' => $user_photo_profile,
        'nb_likes' => $nb_likes,
        'nb_comments' => $nb_comments
      );

      // Push to "data"
      array_push($publications_arr, $publication);
    }

    // Turn to JSON & output
    echo json_encode($publications_arr);

  } else {
    // No Publication
    echo json_encode(
      array('Aucune publication trouvée !')
    );
  }
