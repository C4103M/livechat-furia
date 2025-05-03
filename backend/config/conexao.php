<?php
function conecta_mysql() {
    $host = 'db'; 
    $user = 'furia';
    $password = 'furia123';
    $database = 'furia_chat';

    $conexao = mysqli_connect($host, $user, $password, $database);
    mysqli_set_charset($conexao, "utf8");
    return $conexao;    
}
