<?php 
include_once '../../config/conexao.php';
header("Access-Control-Allow-Origin: *"); // ou use o domínio específico, ex: http://localhost:5173
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$userId = $_GET['id'] ?? null;

function userDelete($userId) {
    $conn = conecta_mysql();

    // Preparar a consulta para evitar SQL Injection
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $userId); // Vincula o parâmetro como inteiro
        $result = $stmt->execute();

        if ($result) {
            return json_encode([
                "status" => "success",
                "message" => "Usuário deletado com sucesso."
            ]);
        } else {
            return json_encode([
                "status" => "error",
                "message" => "Erro ao deletar usuário: " . $stmt->error
            ]);
        }
    } else {
        return json_encode([
            "status" => "error",
            "message" => "Erro ao preparar a consulta."
        ]);
    }
}

if ($userId) {
    echo userDelete($userId);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "O ID do usuário é obrigatório."
    ]);
}