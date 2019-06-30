<?php
    // Headers
    header('Acess-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instantiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog and post object
    $post = new Post($db);

    // Blog post query
     $result = $post->read();

    //  Check if any posts
    if($result->rowCount() > 0){
        $posts_arr = array();
        $posts_arr['data'] = array();

        while ($row = $result->fetch()) {
            extract($row);

            $post_item = array( 
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body),
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name,
            );

            //Push to "Data"
            array_push($posts_arr, $post_item);
        }
        // Turn to JSON & output
        echo json_encode($posts_arr);
    }else{
        // No posts
        echo json_encode(
            array('message' => 'No posts found',)
        ); 
    }
