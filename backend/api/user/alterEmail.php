<?php
include_once '../../config/conexao.php';
require '../../vendor/autoload.php';
header("Access-Control-Allow-Origin: *"); // ou use o domínio específico, ex: http://localhost:5173
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

//Criar token
include_once './createToken.php';
$config = require '../../config/key.php';

$con = conecta_mysql();

$id = $_GET['id'] ?? null;
$newEmail = $_GET['newEmail'] ?? null;
$password = $_GET['senha'] ?? null;

function alterEmail($id, $newEmail, $senha) {
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

            // Verificar a senha
            if (password_verify($senha, $user['password'])) {
                // Preparar a consulta para atualizar o email
                $query2 = "UPDATE users SET email = ? WHERE id = ?";
                $stmt2 = $con->prepare($query2);

                if ($stmt2) {
                    $stmt2->bind_param("si", $newEmail, $id);
                    $updateResult = $stmt2->execute();

                    if ($updateResult) {
                        $user['email'] = $newEmail;
                        $user['password'] = null;
                        $payload = createPayLoad($user);
                        $token = createToken($payload);

                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Email alterado com sucesso!',
                            'token' => $token
                        ]);
                        return;
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Erro ao alterar o email!'
                        ]);
                        return;
                    }
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Erro ao preparar a consulta de atualização!'
                    ]);
                    return;
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Senha incorreta!'
                ]);
                return;
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Usuário não encontrado!'
            ]);
            return;
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erro ao preparar a consulta de busca!'
        ]);
        return;
    }
}

alterEmail($id, $newEmail, $password);