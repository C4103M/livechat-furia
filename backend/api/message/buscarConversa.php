<?php 
include_once("../../config/conexao.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
$con = conecta_mysql();

$remetente_id = isset($_POST['remetente_id']) ? $_POST['remetente_id'] : null;
$destinatario_id = isset($_POST['destinatario_id']) ? $_POST['destinatario_id'] : null;


function buscarConversa($remetente_id, $destinatario_id) {
    global $con;
    $remetente_id = mysqli_real_escape_string($con, $remetente_id);
    $destinatario_id = mysqli_real_escape_string($con, $destinatario_id);

    $querry = "SELECT * FROM mensagens WHERE (remetente_id = '$remetente_id' AND destinatario_id = '$destinatario_id')
    OR (remetente_id = '$destinatario_id' AND destinatario_id = '$remetente_id') ORDER BY timestamp ASC;";
    $result = mysqli_query($con, $querry);
    $arr = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row;
    }
    if (!empty($arr)) {
        return json_encode([
            'status' => 'success',
            'message' => 'Sucesso',
            'codigo' => '',
            'data' => $arr
        ]);
    }
    return json_encode(['status' => '   ', 'message' => "Não há conversas entre esses usuários"]);
}

if($remetente_id AND $destinatario_id) {
    echo buscarConversa($remetente_id, $destinatario_id);
}
// echo buscarConversa(1, 3);