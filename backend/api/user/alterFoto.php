<?php
include_once '../../config/conexao.php';
require '../../vendor/autoload.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include_once './createToken.php';
$config = require '../../config/key.php';

$con = conecta_mysql();

$id = $_POST['id'] ?? null;  // Captura o ID da requisição POST
$newFoto = $_FILES['foto'] ?? null;  // Captura o arquivo de foto
// var_dump($_FILES);
if (!$newFoto || $newFoto['error'] !== UPLOAD_ERR_OK) {
    // Verifica se o arquivo foi enviado corretamente
    echo json_encode(['status' => 'error', 'message' => 'Erro ao enviar o arquivo!']);
    return;
}

function alterFoto($id, $newFoto)
{
    global $con;
    $query1 = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($con, $query1);
    $user = mysqli_fetch_assoc($result);

    $novoNomeFoto = uploadFoto($newFoto, $user['img']);
    if (!$novoNomeFoto) {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao salvar a foto!']);
        return;
    }
    $query2 = "UPDATE users SET img = '$novoNomeFoto' WHERE id = $id";
    if (mysqli_query($con, $query2)) {
        $caminho = 'http://127.0.0.1:8080' . '/uploads/perfil/' . $novoNomeFoto;
        $user['img'] = $caminho;
        $user['password'] = null;
        $payload = createPayLoad($user);
        $token = createToken($payload);
        echo json_encode(['status' => 'success', 'message' => 'Foto alterada com sucesso!', 'token' => $token]);
        return;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar o banco de dados!']);
        return;
    }
}

function uploadFoto($newFoto, $fotoAntiga)
{
    $pastaDestino = '../../uploads/perfil/';

    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0777, true);
    }

    if ($fotoAntiga && file_exists($pastaDestino . $fotoAntiga)) {
        unlink($pastaDestino . $fotoAntiga);
    }

    $nomeArquivo = basename($newFoto['name']);
    $nomeUnico = time() . '_' . $nomeArquivo;
    $caminhoFinal = $pastaDestino . $nomeUnico;

    if (move_uploaded_file($newFoto['tmp_name'], $caminhoFinal)) {
        return $nomeUnico;
    } else {
        return false;
    }
}

alterFoto($id, $newFoto);
