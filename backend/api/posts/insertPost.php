<?php
include_once("../../config/conexao.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
$con = conecta_mysql();

$titulo = isset($_POST['titulo']) ? $_POST['titulo'] : null;
$subtitulo = isset($_POST['subtitulo']) ? $_POST['subtitulo'] : null;
$slug = isset($_POST['slug']) ? $_POST['slug'] : null;
$conteudo = isset($_POST['conteudo']) ? $_POST['conteudo'] : null;
$imagem = isset($_FILES['imagem']) ? $_FILES['imagem'] : null;
$autor_id = isset($_POST['autor_id']) ? $_POST['autor_id'] : null;
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;

function insertPost($titulo, $subtitulo, $slug, $conteudo, $imagem, $autor_id, $categoria)
{
    global $con;
    $imagem_url = insertImagePost($imagem);
    if ($imagem_url) {
        $imagem_url = 'http://127.0.0.1:8080/uploads/postsImg/' . $imagem_url;
    } else {
        $imagem_url = ''; // ou NULL, mas vazio é melhor se for string no banco
    }
    $imagem_url = mysqli_real_escape_string($con, $imagem_url ?? '');
    $titulo = mysqli_real_escape_string($con, $titulo);
    $subtitulo = mysqli_real_escape_string($con, $subtitulo);
    $slug = mysqli_real_escape_string($con, $slug);
    $conteudo = mysqli_real_escape_string($con, $conteudo);
    $imagem_url = mysqli_real_escape_string($con, $imagem_url);
    $categoria = mysqli_real_escape_string($con, $categoria);

    $autor_nome = getAutorNome($autor_id);


    $post_querry = "INSERT INTO posts (titulo, subtitulo, slug, conteudo, imagem_url, autor_id, autor_nome, categoria) VALUES 
    ('$titulo', '$subtitulo', '$slug', '$conteudo', '$imagem_url', '$autor_id', '$autor_nome', '$categoria')";
    $result = mysqli_query($con, $post_querry);
    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Publicação realizada com sucesso!',
            'codigo' => ''
        ]);
        return;
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erro ao verificar usuário',
            'codigo' => ''
        ]);
        return;
    }
}

function insertImagePost($imagem)
{
    if (!$imagem || !isset($imagem['name']) || !isset($imagem['tmp_name'])) {
        return false;
    }

    $pastaDestino = '../../uploads/postsImg/';
    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0777, true);
    }

    $nomeArquivo = basename($imagem['name']);
    $nomeUnico = time() . '_' . $nomeArquivo;
    $caminhoFinal = $pastaDestino . $nomeUnico;

    if (move_uploaded_file($imagem['tmp_name'], $caminhoFinal)) {
        return $nomeUnico;
    } else {
        return false;
    }
}

function getAutorNome($id) {
    global $con;
    $querry = "SELECT name FROM users WHERE id = '$id'";
    $result = mysqli_query($con, $querry);
    if($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['name'];
    }

}


if ($titulo) {
    insertPost($titulo, $subtitulo, $slug, $conteudo, $imagem, $autor_id, $categoria);  
}
