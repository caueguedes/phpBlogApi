<?php
    header('Content-Type: application/json');
    header('Acess-Control-Allow-Origin: *');
    header('Acess-Control-Allow-Methods: DELETE');
    header('Acess-Control-Allow-Methods: Acess-Control-Allow-Headers, Acess-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');

    include_once('../../config/Database.php');
    include_once('../../models/Category.php');

    $database = new Database();
    $db = $database->connect();

    $category = new Category($db);

    $data = json_decode(file_get_contents("php://input"));

    $category->id = $data->id;

    if($category->delete()){
        echo json_encode(
            array('message' => 'Category Deleted'));
    }else {
        echo json_encode(
            array('message' => 'Category not deleted'));
    }
