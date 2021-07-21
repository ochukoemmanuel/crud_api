<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here
include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->getConnection();

// Instantiate post object
$post = new Post($db);

// BLog post query
$result = $post->read();
// Get row count
$num = $result->rowCount();

// Check if more than 0 record found
if($num > 0) {
    // products array
    $posts_arr = array();
    $post_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category _id' => $category_id,
            'category_name' => $category_name
        );

        // Push to "data"
        array_push($posts_arr['data'], $post_item);
}

// show products data in json format
echo json_encode($posts_arr);

} else {
    // No Posts
    echo json_encode(
        array('message' => 'No Posts Found')
    );
}