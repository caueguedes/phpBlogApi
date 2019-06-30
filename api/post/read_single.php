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

    // Get id
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get Post
    $post->readSingle();

    // Create array
    $post_arr = array(
        'id' => $post->id,
        'title' => $post->title,
        'body' => $post->body,
        'author' => $post->author,
        'category_id' => $post->category_id,
        'category_name' => $post->category_name,
    );

    print_r(json_encode($post_arr));     

