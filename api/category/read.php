<?php
    header('Acess-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once('../../config/Database.php');
    include_once('../../models/Category.php');

    $database = new Database();
    $db = $database->connect();

    $category = new Category($db);

    $result = $category->read();

    if($result->rowCount() > 0){
        $category_arr = array();
        $category_arr['data'] = array();

        // var_dump($result->fetch());
        while($row = $result->fetch()){
            extract($row);

            $category_item = array(
                'id' => $id,
                'name' => $name,
                'created_at' => $created_at
            );

            array_push($category_arr['data'], $category_item);
        }
        echo json_encode($category_arr);
    }else {
        echo json_encode(
            array('message' => 'No catagories Found',)
        );
    }
