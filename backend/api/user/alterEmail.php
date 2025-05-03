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
    $querry1 = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($con, $querry1);
    $user = mysqli_fetch_assoc($result);
    if(password_verify($senha, $user['password'])) {
        $query2 = "UPDATE users SET email = '$newEmail' WHERE id = $id";
        if (mysqli_query($con, $query2)) {
            $user['email'] = $newEmail;
            $user['password'] = null;
            $payload = createPayLoad($user);
            $token = createToken($payload);
            echo json_encode(['status' => 'success', 'message' => 'Nome alterado com sucesso!', 'token' => $token]);
            return;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao alterar o email!']);
            return;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Senha incorreta!']);
        return;
    }
}

alterEmail($id, $newEmail, $password); 
?>