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

function inserirComentario($slug, $id_autor, $conteudo) {
    global $con;

    $nome = getName($id_autor);
    $img = getImage($id_autor);
    
    $query = "INSERT INTO comentarios (autor_id, conteudo, slug, name_autor, img_autor) 
    VALUES ('$id_autor', '$conteudo', '$slug', '$nome', '$img')";

    $result = mysqli_query($con, $query);

    if($result) {
        return json_encode([
            'status' => 'success',
            'message' => 'Comentário Incluido com sucesso',
            'codigo' => 200
        ]);
    }else{
        return json_encode([
            'status' => 'error',
            'message' => 'Comentário Não incluido',
            'codigo' => 201
        ]);
    }
}


function getName($id) {
    global $con;
    $query = "SELECT name FROM users WHERE id = '$id'";
    $result = mysqli_query($con, $query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['name'];
    }
    return null;
}

function getImage($id) {
    global $con;
    $query = "SELECT img FROM users WHERE id = $id";
    $result = mysqli_query($con, $query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['img'];
    }
    return null;
}

if($slug) {
    echo inserirComentario($slug, $id_autor, $conteudo);
}

// echo getName(1);
// echo getImage(1);