<?php
include_once './createToken.php';

header("Access-Control-Allow-Origin: *"); // ou use o domínio específico, ex: http://localhost:5173
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$email = $_GET['email'] ?? null;
$senha = $_GET['senha'] ?? null;
$nome = $_GET['nome'] ?? null;

include_once '../../config/conexao.php';

function userCadastro($email, $senha, $nome) {
    $conexao = conecta_mysql();

    // Verifica se o email é repetido
    if (verificarEmail($email, $conexao)) {
        echo json_encode(['status' => 'error', 'message' => 'Email já cadastrado.', 'codigo' => 409]);
        return;
    }

    // Criptografa a senha
    $senha = criptografarSenha($senha);

    // Insere o usuário no banco de dados
    $query = "INSERT INTO users(name, email, password) VALUES (?, ?, ?)";
    $stmt = $conexao->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sss", $nome, $email, $senha);
        $result = $stmt->execute();

        if ($result) {
            $user = consultaUsuario($email, $conexao);

            if ($user) {
                if ($user['img'] != null) {
                    $caminho = 'http://127.0.0.1:8080/uploads/perfil/' . $user['img'];
                    $user['img'] = $caminho;
                }
                $token = createPayLoad($user);
                $token = createToken($token);
                echo json_encode(['status' => 'success', 'message' => 'Usuário cadastrado com sucesso', 'codigo' => 200, 'token' => $token]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao consultar usuário.', 'codigo' => 500]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar usuário.', 'codigo' => 500]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao preparar a consulta.', 'codigo' => 500]);
    }
}

function criptografarSenha($senha) {
    return password_hash($senha, PASSWORD_DEFAULT);
}

function verificarEmail($email, $conexao) {
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conexao->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    return false;
}

function consultaUsuario(string $email, $conexao): array {
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conexao->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc() ?? [];
    }

    return [];
}

if ($email && $senha && $nome) {
    userCadastro($email, $senha, $nome);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Preencha todos os campos.', 'codigo' => 400]);
}