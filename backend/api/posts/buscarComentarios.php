<?php 
include_once("../../config/conexao.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
$con = conecta_mysql();

$slug = isset($_GET['slug']) ? $_GET['slug'] : null;

function buscarComentarios($slug) {
    global $con;

    $querry = "SELECT * FROM comentarios WHERE slug = '$slug'";
    $result = mysqli_query($con, $querry);
    // $result = mysqli_fetch_all($result);
    $comentarios = [];
    if($result) {
        $comentarios = mysqli_fetch_all($result, MYSQLI_ASSOC); // Retorna todas as linhas como um array associativo
        // Atualiza o campo img_autor para incluir o caminho completo
        foreach ($comentarios as &$comentario) {
            if (!empty($comentario['img_autor'])) {
                $comentario['img_autor'] = 'http://127.0.0.1:8080/uploads/perfil/' . $comentario['img_autor'];
            }
        }
        return json_encode([
            'status' => 'success',
            'message' => 'Sucesso',
            'codigo' => 200,
            'data' => $comentarios // Retorna o array de comentários
        ]);
    } else {
        return json_encode([
            'status' => 'error',
            'message' => 'Erro ao buscar comentários',
            'codigo' => 500,
            'data' => []
        ]);
    }
}
    
// if($slug) {
//     echo buscarComentarios($slug);
// }
// echo("Valor do slug recebido: " . $slug);
echo buscarComentarios('nova-camisa-furia-2025');