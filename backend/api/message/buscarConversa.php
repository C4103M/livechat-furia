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

function buscarConversa($remetente_id, $destinatario_id, $con) {
    // Preparar a query com placeholders
    $query = "SELECT * FROM mensagens WHERE (remetente_id = ? AND destinatario_id = ?) 
              OR (remetente_id = ? AND destinatario_id = ?) ORDER BY timestamp ASC";
    
    // Preparar a declaração
    $stmt = $con->prepare($query);

    if ($stmt) {
        // Vincular os parâmetros (tipo inteiro)
        $stmt->bind_param("iiii", $remetente_id, $destinatario_id, $destinatario_id, $remetente_id);
        
        // Executar a query
        $stmt->execute();

        // Obter o resultado
        $result = $stmt->get_result();
        $arr = [];

        // Adicionar os resultados ao array
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }

        $stmt->close();

        // Verificar se há resultados
        if (!empty($arr)) {
            return json_encode([
                'status' => 'success',
                'message' => 'Sucesso',
                'codigo' => '',
                'data' => $arr
            ]);
        }
    }

    return json_encode(['status' => 'error', 'message' => "Não há conversas entre esses usuários"]);
}

if($remetente_id && $destinatario_id) {
    echo buscarConversa($remetente_id, $destinatario_id, $con);
}
?>
