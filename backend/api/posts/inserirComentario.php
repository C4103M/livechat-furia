<?php 
include_once("../../config/conexao.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$con = conecta_mysql();

$slug = isset($_POST['slug']) ? $_POST['slug'] : null;
$id_autor = isset($_POST['id_autor']) ? $_POST['id_autor'] : null;
$conteudo = isset($_POST['conteudo']) ? $_POST['conteudo'] : null;

function inserirComentario($slug, $id_autor, $conteudo, $con) {
    $nome = getName($id_autor, $con);
    $img = getImage($id_autor, $con);

    // Usando prepared statements para evitar SQL Injection
    $query = "INSERT INTO comentarios (autor_id, conteudo, slug, name_autor, img_autor) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);

    if ($stmt) {
        $stmt->bind_param("issss", $id_autor, $conteudo, $slug, $nome, $img);
        $result = $stmt->execute();

        if ($result) {
            return json_encode([
                'status' => 'success',
                'message' => 'Comentário incluído com sucesso',
                'codigo' => 200
            ]);
        } else {
            return json_encode([
                'status' => 'error',
                'message' => 'Erro ao incluir comentário',
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

function getName($id, $con) {
    $query = "SELECT name FROM users WHERE id = ?";
    $stmt = $con->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['name'];
        }
    }
    return null;
}

function getImage($id, $con) {
    $query = "SELECT img FROM users WHERE id = ?";
    $stmt = $con->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['img'];
        }
    }
    return null;
}

if ($slug && $id_autor && $conteudo) {
    echo inserirComentario($slug, $id_autor, $conteudo, $con);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Dados incompletos',
        'codigo' => 400
    ]);
}