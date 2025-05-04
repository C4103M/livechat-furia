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

if (!$newFoto || $newFoto['error'] !== UPLOAD_ERR_OK) {
    // Verifica se o arquivo foi enviado corretamente
    echo json_encode(['status' => 'error', 'message' => 'Erro ao enviar o arquivo!']);
    return;
}

function alterFoto($id, $newFoto) {
    global $con;

    // Preparar a consulta para buscar o usuário
    $query1 = "SELECT * FROM users WHERE id = ?";
    $stmt1 = $con->prepare($query1);

    if ($stmt1) {
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $result = $stmt1->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Fazer o upload da nova foto
            $novoNomeFoto = uploadFoto($newFoto, $user['img']);
            if (!$novoNomeFoto) {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao salvar a foto!']);
                return;
            }

            // Preparar a consulta para atualizar a foto no banco de dados
            $query2 = "UPDATE users SET img = ? WHERE id = ?";
            $stmt2 = $con->prepare($query2);

            if ($stmt2) {
                $stmt2->bind_param("si", $novoNomeFoto, $id);
                $updateResult = $stmt2->execute();

                if ($updateResult) {
                    $caminho = 'http://127.0.0.1:8080/uploads/perfil/' . $novoNomeFoto;
                    $user['img'] = $caminho;
                    $user['password'] = null;
                    $payload = createPayLoad($user);
                    $token = createToken($payload);

                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Foto alterada com sucesso!',
                        'token' => $token
                    ]);
                    return;
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar o banco de dados!']);
                    return;
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao preparar a consulta de atualização!']);
                return;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Usuário não encontrado!']);
            return;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao preparar a consulta de busca!']);
        return;
    }
}

function uploadFoto($newFoto, $fotoAntiga) {
    $pastaDestino = '../../uploads/perfil/';

    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0777, true);
    }

    // Remover a foto antiga, se existir
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