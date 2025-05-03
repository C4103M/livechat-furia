<?php
header("Access-Control-Allow-Origin: *"); // ou use o domínio específico, ex: http://localhost:5173
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
function getUserList()
{
    include_once '../../config/conexao.php';
    $conexao = conecta_mysql();
    return mysqli_query($conexao, "SELECT * FROM users");
}

$usuarios = getUserList();
$listaUsuarios = [];

if ($usuarios) {
    foreach ($usuarios as $usuario) {
        if ($usuario['img'] != null) {
            $caminho = 'http://127.0.0.1:8080/uploads/perfil/' . $usuario['img'];
            $usuario['img'] = $caminho;
        }
        $listaUsuarios[] = $usuario;
    }
}
// $listaUsuarios = mysqli_fetch_assoc($usuarios);
// print_r($listaUsuarios);
header('Content-Type: application/json'); // Define o tipo de resposta como JSON
echo json_encode($listaUsuarios);
