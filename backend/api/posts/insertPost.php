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

function insertPost($titulo, $subtitulo, $slug, $conteudo, $imagem, $autor_id, $categoria, $con) {
    $imagem_url = insertImagePost($imagem);
    if ($imagem_url) {
        $imagem_url = 'http://127.0.0.1:8080/uploads/postsImg/' . $imagem_url;
    } else {
        $imagem_url = ''; // ou NULL, mas vazio é melhor se for string no banco
    }

    $autor_nome = getAutorNome($autor_id, $con);

    // Usando prepared statements para evitar SQL Injection
    $query = "INSERT INTO posts (titulo, subtitulo, slug, conteudo, imagem_url, autor_id, autor_nome, categoria) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ssssssss", $titulo, $subtitulo, $slug, $conteudo, $imagem_url, $autor_id, $autor_nome, $categoria);
        $result = $stmt->execute();

        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Publicação realizada com sucesso!',
                'codigo' => 200
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao inserir publicação.',
                'codigo' => 500
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erro ao preparar a consulta.',
            'codigo' => 500
        ]);
    }
}

function insertImagePost($imagem) {
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

function getAutorNome($id, $con) {
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

if ($titulo && $subtitulo && $slug && $conteudo && $autor_id && $categoria) {
    insertPost($titulo, $subtitulo, $slug, $conteudo, $imagem, $autor_id, $categoria, $con);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Dados incompletos.',
        'codigo' => 400
    ]);
}