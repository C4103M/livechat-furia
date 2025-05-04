<?php 
include_once("../../config/conexao.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$con = conecta_mysql();

$slug = isset($_POST["slug"]) ? $_POST["slug"] : null; 

function buscarPorSlug($slug, $con) {
    // Preparar a consulta com o placeholder para o slug
    $query = "SELECT * FROM posts WHERE slug = ?";

    // Preparar a declaração
    if ($stmt = $con->prepare($query)) {
        // Vincular o parâmetro (s para string)
        $stmt->bind_param("s", $slug);
        
        // Executar a consulta
        $stmt->execute();
        
        // Obter o resultado
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $post = $result->fetch_assoc();
            return json_encode([
                'status' => 'success',
                'message' => 'Publicação encontrada',
                'codigo' => '',
                'data' => $post
            ]);
        } else {
            return json_encode([
                'status' => 'error',
                'message' => 'Publicação não encontrada, por favor digite um URL válido',
                'codigo' => ''
            ]);
        }
    } else {
        return json_encode([
            'status' => 'error',
            'message' => 'Erro ao preparar a consulta',
            'codigo' => ''
        ]);
    }
}

if ($slug) {
    echo buscarPorSlug($slug, $con);
}
?>
