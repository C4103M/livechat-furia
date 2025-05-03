<?php 
include_once("../../config/conexao.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
$con = conecta_mysql();

function listNews() {
    global $con;
    $query = "SELECT * FROM posts";
    $result = mysqli_query($con, $query);

    if ($result) {
        $news = mysqli_fetch_all($result, MYSQLI_ASSOC); // Retorna todas as linhas como um array associativo
        return json_encode([
            'status' => 'success',
            'message' => 'Operação realizada com sucesso!',
            'codigo' => '',
            'data' => $news // Retorna todas as notícias
        ]);
    } else {
        return json_encode([
            'status' => 'error',
            'message' => 'Erro ao realizar a consulta',
            'codigo' => ''
        ]);
    }
}

print listNews();