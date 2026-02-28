<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(["message" => "Method tidak diizinkan."]);
    exit;
}

include_once '../config/Database.php';
include_once '../models/Task.php';

$database = new Database();
$db = $database->getConnection();

$task = new Task($db);
$data = json_decode(file_get_contents("php://input"));

// Pastikan data lengkap
if (!empty($data->id) && !empty($data->title) && !empty($data->description) && !empty($data->status)) {
    $task->id = $data->id;
    $task->title = $data->title;
    $task->description = $data->description;
    $task->status = $data->status; // 'Pending' atau 'Selesai'

    if ($task->update()) {
        http_response_code(200);
        echo json_encode(["message" => "Task berhasil diperbarui."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Gagal memperbarui task."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Data tidak lengkap."]);
}
?>