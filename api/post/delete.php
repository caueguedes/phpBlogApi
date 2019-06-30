<?php
    header('Acess-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Acess-Control-Allow-Methods: DELETE');
    header('Acess-Control-Allow-Methods: Acess-Control-Allow-Headers, Content-Type, Acess-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    $database = new Database();
    $db = $database->connect();

    $post = new Post($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $post->id = $data->id;

    if($post->delete()){
        echo json_encode(
            array('message' => 'Post deleted', )
        );
    }else{
        echo json_encode(
            array('message' => 'Post not deleted')
        );
    }
