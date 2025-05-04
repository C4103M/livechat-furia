<?php 
include_once("../../config/conexao.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$con = conecta_mysql();

$slug = isset($_GET['slug']) ? $_GET['slug'] : null;

function buscarComentarios($slug, $con) {
    // Preparar a consulta com um placeholder para o slug
    $query = "SELECT * FROM comentarios WHERE slug = ?";
    
    // Preparar a declaração
    if ($stmt = $con->prepare($query)) {
        // Vincular o parâmetro (s para string)
        $stmt->bind_param("s", $slug);
        
        // Executar a consulta
        $stmt->execute();
        
        // Obter o resultado
        $result = $stmt->get_result();
        
        $comentarios = [];
        if ($result->num_rows > 0) {
            $comentarios = $result->fetch_all(MYSQLI_ASSOC);
            
            // Atualiza o campo img_autor para incluir o caminho completo
            foreach ($comentarios as &$comentario) {
                if (!empty($comentario['img_autor'])) {
                    $comentario['img_autor'] = 'http://127.0.0.1:8080/uploads/perfil/' . $comentario['img_autor'];
                }
            }
            // Retorna os comentários
            return json_encode([
                'status' => 'success',
                'message' => 'Sucesso',
                'codigo' => 200,
                'data' => $comentarios
            ]);
        } else {
            return json_encode([
                'status' => 'error',
                'message' => 'Nenhum comentário encontrado.',
                'codigo' => 404,
                'data' => []
            ]);
        }
    } else {
        return json_encode([
            'status' => 'error',
            'message' => 'Erro ao preparar a consulta.',
            'codigo' => 500,
            'data' => []
        ]);
    }
}

if($slug) {
    echo buscarComentarios($slug, $con);
}
?>
