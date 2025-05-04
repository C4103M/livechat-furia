<?php
include_once './createToken.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$email = $_GET['email'] ?? null;
$senha = $_GET['senha'] ?? null;

include_once '../../config/conexao.php';

function userLogin($email, $senha)
{
    $conexao = conecta_mysql();

    // Preparar a consulta para evitar SQL Injection
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conexao->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $email); // Vincula o parâmetro como string
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verificar a senha
            if (password_verify($senha, $user['password'])) {
                $user['password'] = null; // Remove a senha do retorno

                // Adicionar o caminho completo da imagem, se existir
                if ($user['img'] != null) {
                    $caminho = 'http://127.0.0.1:8080/uploads/perfil/' . $user['img'];
                    $user['img'] = $caminho;
                }

                // Criar o token JWT
                $payload = createPayLoad($user);
                $token = createToken($payload);

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Login Realizado!',
                    'codigo' => 200,
                    'token' => $token
                ]);
                return;
            } else {
                echo json_encode([
                    'status' => 'error',
                    'codigo' => 401,
                    'message' => 'Senha incorreta.'
                ]);
                return;
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'codigo' => 404,
                'message' => 'Email não encontrado.'
            ]);
            return;
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'codigo' => 500,
            'message' => 'Erro ao preparar a consulta.'
        ]);
        return;
    }
}

if ($email && $senha) {
    userLogin($email, $senha);
} else {
    echo json_encode([
        'status' => 'error',
        'codigo' => 400,
        'message' => 'Email e senha são obrigatórios.'
    ]);
}