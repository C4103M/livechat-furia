<?php
function getUserData($id) {
    include_once '../../config/conexao.php';
    $conexao = conecta_mysql();
    return mysqli_query($conexao, "SELECT * FROM users WHERE id = $id");
}

$id = $_GET['id'];

$usuario = getUserData($id);
$usuario = mysqli_fetch_assoc($usuario);
echo json_encode($usuario);
    