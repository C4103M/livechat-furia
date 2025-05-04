<?php 
include_once("../../config/conexao.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
$con = conecta_mysql();

$remetente_id = isset($_POST['remetente_id']) ? $_POST['remetente_id'] : null;
$destinatario_id = isset($_POST['destinatario_id']) ? $_POST['destinatario_id'] : null;
$conteudo = isset($_POST['conteudo']) ? $_POST['conteudo'] : null;

function enviarMensagem($remetente_id, $destinatario_id, $conteudo) {
    global $con;
    
    $remetente_id = mysqli_real_escape_string($con, $remetente_id);
    $destinatario_id = mysqli_real_escape_string($con, $destinatario_id);
    $conteudo = mysqli_real_escape_string($con, $conteudo);

    $querry = "INSERT INTO mensagens (remetente_id, destinatario_id, content) VALUES ('$remetente_id', '$destinatario_id', '$conteudo')";
    $result = mysqli_query($con, $querry);

    if($result) {
        return json_encode([
            'status' => 'success',
            'message' => 'Usuário inserido com sucesso!',
            'codigo' => ''
        ]);
    }
    else {
        return json_encode(['status' => 'error']);
    }

}

if($remetente_id) {
    echo enviarMensagem($remetente_id, $destinatario_id, $conteudo);
}