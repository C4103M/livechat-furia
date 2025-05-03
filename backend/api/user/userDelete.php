<?php 
include_once '../../config/conexao.php';
header("Access-Control-Allow-Origin: *"); // ou use o domínio específico, ex: http://localhost:5173
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
$userId = $_GET['id'] ? $_GET['id'] : null;
// $userId = 6;
// Include database connection
function userDelete($userId) {
    $conn = conecta_mysql();
    $querry = "DELETE FROM users WHERE id = $userId";
    $result = mysqli_query($conn, $querry);
    if ($result) {
        return json_encode(array("status" => "success", "message" => "User deleted successfully."));
    } else {
        return json_encode(array("status" => "error", "message" => "Error deleting user: " . mysqli_error($conn)));
    }
    
}

if($userId) {
    echo userDelete($userId);
} else {
    echo json_encode(array("status" => "error", "message" => "User ID is required."));
}