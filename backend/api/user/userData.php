<?php
function getUserData($id) {
    include_once '../../config/conexao.php';
    $conexao = conecta_mysql();

    // Preparar a consulta para evitar SQL Injection
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conexao->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $id); // Vincula o parâmetro como inteiro
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Retorna os dados do usuário como array associativo
        }
    }

    return null; // Retorna null se o usuário não for encontrado
}

$id = $_GET['id'] ?? null;

if ($id) {
    $usuario = getUserData($id);
    if ($usuario) {
        echo json_encode($usuario);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Usuário não encontrado.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID não fornecido.']);
}