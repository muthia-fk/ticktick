<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["message" => "Method tidak diizinkan."]);
    exit;
}

// Pastikan path sesuai struktur folder kamu
include_once '../config/Database.php';
include_once '../models/Task.php';

$database = new Database();
$db = $database->getConnection();

$task = new Task($db);
$data = json_decode(file_get_contents("php://input"));

// Validasi input
if (!empty($data->title) && !empty($data->description) && !empty($data->status)) {
    $task->title = $data->title;
    $task->description = $data->description;
    $task->status = $data->status; // 'Pending' atau 'Selesai'

    if ($task->create()) {
        http_response_code(201);
        echo json_encode(["message" => "Task berhasil ditambahkan."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Gagal menambahkan task."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Data tidak lengkap."]);
}
?>