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
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;

function editPost($titulo, $subtitulo, $slug, $conteudo, $imagem, $categoria) {
    global $con;
    // print_r($imagem);
    $titulo = mysqli_real_escape_string($con, $titulo);
    $subtitulo = mysqli_real_escape_string($con, $subtitulo);
    $slug = mysqli_real_escape_string($con, $slug);
    $conteudo = mysqli_real_escape_string($con, $conteudo);
    $categoria = mysqli_real_escape_string($con, $categoria);
    if(is_array($imagem)) {
        $imagem = updateImage(getFotoAntiga($slug),$imagem);
        $imagem = 'http://127.0.0.1:8080/uploads/postsImg/' . $imagem;
        $imagem = mysqli_real_escape_string($con, $imagem ?? '');
     
        $querry = "UPDATE posts SET titulo = '$titulo', 
        subtitulo = '$subtitulo', conteudo = '$conteudo',
        imagem_url = '$imagem', categoria = '$categoria' 
        WHERE slug = '$slug'";
    
        $result = mysqli_query($con, $querry);
    } else {
        $querry = "UPDATE posts SET titulo = '$titulo', 
        subtitulo = '$subtitulo', conteudo = '$conteudo',
        categoria = '$categoria' WHERE slug = '$slug'";
    
        $result = mysqli_query($con, $querry);
    }
    
    if($result) {
        return json_encode([
            'status' => 'success',
            'message' => 'Atualizado com sucesso',
            'codigo' => ''
        ]);
    }
    return json_encode([
        'status' => 'error',
        'message' => 'Erro ao atualizar',
        'codigo' => ''
    ]);

}

function updateImage($fotoAntiga, $imagem) {
    $pastaDestino = '../../uploads/postsImg/';

    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0777, true);
    }

    if ($fotoAntiga && file_exists($pastaDestino . $fotoAntiga)) {
        unlink($pastaDestino . $fotoAntiga);
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

function getFotoAntiga($slug) {
    global $con;
    $querry = "SELECT imagem_url FROM posts WHERE slug = '$slug'";
    $result = mysqli_query($con, $querry);
    $result = mysqli_fetch_assoc($result);
    $foto = $result['imagem_url'];

    $foto = str_replace('http://127.0.0.1:8080/uploads/postsImg/', '', $foto);  
    return $foto;
}

if($slug) {
    echo editPost($titulo, $subtitulo, $slug, $conteudo, $imagem, $categoria);
}
// echo getFotoAntiga('nova-camisa-furia-2025');