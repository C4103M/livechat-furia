<?php 
include_once("../../config/conexao.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Conectar ao banco usando a função conecta_mysql()
$con = conecta_mysql();

$remetente_id = isset($_POST['remetente_id']) ? $_POST['remetente_id'] : null;
$destinatario_id = isset($_POST['destinatario_id']) ? $_POST['destinatario_id'] : null;
$conteudo = isset($_POST['conteudo']) ? $_POST['conteudo'] : null;

function enviarMensagem($remetente_id, $destinatario_id, $conteudo, $con) {
    // Preparar a query com placeholders
    $query = "INSERT INTO mensagens (remetente_id, destinatario_id, content) VALUES (?, ?, ?)";
    
    // Preparar a declaração
    $stmt = $con->prepare($query);

    if ($stmt) {
        // Vincular os parâmetros (tipo inteiro para remetente_id e destinatario_id, string para conteudo)
        $stmt->bind_param("iis", $remetente_id, $destinatario_id, $conteudo);
        
        // Executar a query
        if ($stmt->execute()) {
            $stmt->close();
            return json_encode([
                'status' => 'success',
                'message' => 'Mensagem enviada com sucesso!',
                'codigo' => ''
            ]);
        } else {
            $stmt->close();
            return json_encode(['status' => 'error', 'message' => 'Erro ao enviar mensagem.']);
        }
    } else {
        return json_encode(['status' => 'error', 'message' => 'Erro ao preparar a consulta.']);
    }
}

if ($remetente_id && $destinatario_id && $conteudo) {
    echo enviarMensagem($remetente_id, $destinatario_id, $conteudo, $con);
}
?>
