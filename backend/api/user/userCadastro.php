<?php
include_once './createToken.php';

header("Access-Control-Allow-Origin: *"); // ou use o domínio específico, ex: http://localhost:5173
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$email = $_GET['email'] ?? null;
$senha = $_GET['senha'] ?? null;
$nome = $_GET['nome'] ?? null;

// $email = 'cintia@rosana';
// $senha = '123';
// $nome = 'Cintia Rosana';



include_once '../../config/conexao.php';
function userCadastro($email, $senha, $nome) {
    $conexao = conecta_mysql();

    // Verifica se o email é repetido
    if(verificarEmail($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Email já cadastrado.', 'codigo' => 409 ]);
        return;
    }
    //Criptografa a senha
    $senha = criptografarSenha($senha);

    //Insere o usuário no banco de dados
    $query = "INSERT INTO users(name, email, password) VALUES ('$nome', '$email', '$senha')";
    $result = mysqli_query($conexao, $query);

    $result = consultaUsuario($email);
    
    //Verifica se o usuário foi inserido com sucesso
    if($result) {
        if ($result['img'] != null) {
            $caminho = 'http://127.0.0.1:8080/uploads/perfil/' . $result['img'];
            $result['img'] = $caminho;
        }
        $token = createPayLoad($result);
        $token = createToken($token);
        echo json_encode(['status' => 'success', 'message' => 'Usuário cadastrado com sucesso', 'codigo' => 200, 'token' => $token]);

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar usuário.', 'codigo' => 400]);
    }
}

function criptografarSenha($senha) {
    return password_hash($senha, PASSWORD_DEFAULT);
}
function verificarEmail($email) {
    $conexao = conecta_mysql();
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conexao, $query);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function consultaUsuario(string $email):array {
    $conexao = conecta_mysql();
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conexao, $query);
    $result = mysqli_fetch_assoc($result);
    
    return $result;
}

if ($email && $senha && $nome) {
    userCadastro($email, $senha, $nome);
} else {
    echo json_encode(['status' => 'Preencha todos os campos.']);
}
