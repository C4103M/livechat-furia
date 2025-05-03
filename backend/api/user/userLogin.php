<?php
include_once './createToken.php';
header("Access-Control-Allow-Origin: *"); // ou use o domínio específico, ex: http://localhost:5173
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$email = $_GET['email'] ?? null;
$senha = $_GET['senha'] ?? null;
// $email = 'caio@emanoel';
// $senha = '123';

include_once '../../config/conexao.php';
function userLogin($email, $senha)
{
    $conexao = conecta_mysql();
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conexao, $query);
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($senha, $user['password'])) {
            $user['password'] = null;
            if ($user['img'] != null) {
                $caminho = 'http://127.0.0.1:8080/uploads/perfil/' . $user['img'];
                $user['img'] = $caminho;
            }
            $payload = createPayLoad($user);
            $token = createToken($payload);
            echo json_encode(['status' => 'success', 'message' => 'Login Realizado!', 'codigo' => 200,'token' => $token]);
            return;
        } else {
            echo json_encode(['status' => 'error','codigo' => 401, 'message' => 'Senha incorreta.']);
            return;
        }
    } else {
        echo json_encode(['status' => 'error', 'codigo' => 404,'message' => 'Email não encontrado.']);
        return;
    }
}

if ($email && $senha) {
    userLogin($email, $senha);
}
