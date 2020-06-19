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
   $post1 = new Post($db);

  // post query
   $result = $post1->read();
   // Get row count
  $num = $result->rowCount();


  // Check if any post
  if($num > 0) {
    // post array
    $posts_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      switch($category) {
        case 'Questions':
            $color = '#F1592A';
            break;
        case 'Vitrines':
             $color = '#3AB54A';
             break;
        case 'Annonces':
             $color = '#8C6238';
             break;
        case 'Emplois':
             $color = '#25AAE2';
             break;
        case 'Stages':
             $color = '#F7941D';
             break;
      }

      $created_at = $post1->ago($created_at);

      $post = array(
        'id' => $id,
        'category' => $category,
        'title' => ucfirst($title),
        'body' => ucwords($body),
        'author_id' => $author_id,
        'author_name' => ucwords($author_name),
        'author_photo_url' => $author_photo_url,
        'response_to' => $response_to,
        'nb_responses' => $nb_responses,
        'created_at' => $created_at,
        'color' => $color
      );

      // Push to "data"
      array_push($posts_arr, $post);
    }

    // Turn to JSON & output
    echo json_encode($posts_arr);

  } else {
    // No Post
    echo json_encode(
      array('Aucun post trouvé !')
    );
  }
