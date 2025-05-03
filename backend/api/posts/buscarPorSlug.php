<?php 
include_once("../../config/conexao.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");
$con = conecta_mysql();

$slug = isset($_POST["slug"]) ? $_POST["slug"] : null; 
// $slug = isset($_GET["slug"]) ? $_GET["slug"] : null; 

function buscarPorSlug($slug) {
    global $con;
    $querry = "SELECT * FROM posts WHERE slug = '$slug'";
    $result = mysqli_query($con, $querry);
    if($result) {
        $result = mysqli_fetch_assoc($result);
        $arr = json_encode([
            'status' => 'success',
            'message' => 'Publicação encontrada',
            'codigo' => '',
            'data' => $result
        ]);
        return $arr;
    } else {
        return json_encode([
            'status' => 'error',
            'message' => 'Publicação não encontrada, por favor digite um URL válida',
            'codigo' => ''
        ]);
    }
}

if($slug) {
    echo (buscarPorSlug($slug));
}