<?php
    header('Acess-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../../config/Database.php');
    include_once('../../models/Category.php');

    $database = new Database();
    $db = $database->connect();

    $category = new Category($db);

    $category->id = isset($_GET['id']) ? $_GET['id'] : die();
    
    $row = $category->readSingle();

    $category_arr = array(
        'id' => $category->id,
        'name' => $category->name,
        'created_at' => $category->created_at,
    );
    
    echo json_encode($category_arr);
    