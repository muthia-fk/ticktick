<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["message" => "Method tidak diizinkan."]);
    exit;
}

include_once '../config/Database.php';
include_once '../models/Task.php';

$database = new Database();
$db = $database->getConnection();

$task = new Task($db);
$stmt = $task->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $tasks_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $task_item = array(
            "id" => $id,
            "title" => $title,
            "description" => $description,
            "status" => $status,
            "created_at" => $created_at
        );

        array_push($tasks_arr, $task_item);
    }

    http_response_code(200);
    echo json_encode($tasks_arr);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Data task tidak ditemukan."]);
}
?>