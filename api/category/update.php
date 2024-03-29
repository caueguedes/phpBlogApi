<?php
    header('Acess-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Acess-Control-Allow-Methods: PUT');
    header('Acess-Control-Allow-Methods: Acess-Control-Allow-Headers, 
        Content-Type, Acess-Control-Allow-Methods, 
        Authorization, X-Requested-With');

    include_once('../../config/Database.php');
    include_once('../../models/Category.php');

    $database = new Database();
    $db = $database->connect();

    $category = new Category($db);
    
    $data = json_decode(file_get_contents("php://input"));

    $category->id = $data->id;
    $category->name = $data->name;

    if($category->update()){
        echo json_encode(
            array('message' => 'Category updated')
        );
    }else{
        echo json_encode(
            array('message' => 'Category not updated')
        );
    }

