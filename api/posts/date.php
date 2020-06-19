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

   $now = time();
   $date = '2020-06-05 08:01:05';

  // post query
   echo $post->ago($date);
   // Get row count


