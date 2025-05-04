<?php 
include_once("../../config/conexao.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
$con = conecta_mysql();

function listNews() {
    global $con;

    // Preparar a consulta
    $query = "SELECT * FROM posts";
    $stmt = $con->prepare($query);

    if ($stmt) {
        // Executar a consulta
        $stmt->execute();

        // Obter o resultado
        $result = $stmt->get_result();

        if ($result) {
            $news = $result->fetch_all(MYSQLI_ASSOC); // Retorna todas as linhas como um array associativo
            return json_encode([
                'status' => 'success',
                'message' => 'Operação realizada com sucesso!',
                'codigo' => 200,
                'data' => $news // Retorna todas as notícias
            ]);
        } else {
            return json_encode([
                'status' => 'error',
                'message' => 'Erro ao obter os resultados',
                'codigo' => 500
            ]);
        }
    } else {
        return json_encode([
            'status' => 'error',
            'message' => 'Erro ao preparar a consulta',
            'codigo' => 500
        ]);
    }
}

print listNews();