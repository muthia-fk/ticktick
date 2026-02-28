<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
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

// Pastikan ID ada
if (!empty($data->id)) {
    $task->id = $data->id;

    if ($task->delete()) {
        http_response_code(200);
        echo json_encode(["message" => "Task berhasil dihapus."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Gagal menghapus task."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "ID task tidak ditemukan."]);
}
?>