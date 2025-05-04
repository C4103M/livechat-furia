<?php
header("Access-Control-Allow-Origin: *"); // ou use o domínio específico, ex: http://localhost:5173
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

function getUserList()
{
    include_once '../../config/conexao.php';
    $conexao = conecta_mysql();

    // Preparar a consulta para evitar SQL Injection
    $query = "SELECT * FROM users";
    $stmt = $conexao->prepare($query);

    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC); // Retorna todos os usuários como um array associativo
        }
    }

    return [];
}

$usuarios = getUserList();
$listaUsuarios = [];

if ($usuarios) {
    foreach ($usuarios as $usuario) {
        if ($usuario['img'] != null) {
            $caminho = 'http://127.0.0.1:8080/uploads/perfil/' . $usuario['img'];
            $usuario['img'] = $caminho;
        }
        $listaUsuarios[] = $usuario;
    }
}

echo json_encode($listaUsuarios);