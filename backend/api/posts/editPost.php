<?php 
include_once("../../config/conexao.php");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$con = conecta_mysql();

$titulo = isset($_POST['titulo']) ? $_POST['titulo'] : null;
$subtitulo = isset($_POST['subtitulo']) ? $_POST['subtitulo'] : null;
$slug = isset($_POST['slug']) ? $_POST['slug'] : null;
$conteudo = isset($_POST['conteudo']) ? $_POST['conteudo'] : null;
$imagem = isset($_FILES['imagem']) ? $_FILES['imagem'] : null;
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;

function editPost($titulo, $subtitulo, $slug, $conteudo, $imagem, $categoria, $con) {
    // Usando prepared statement para segurança
    $titulo = mysqli_real_escape_string($con, $titulo);
    $subtitulo = mysqli_real_escape_string($con, $subtitulo);
    $slug = mysqli_real_escape_string($con, $slug);
    $conteudo = mysqli_real_escape_string($con, $conteudo);
    $categoria = mysqli_real_escape_string($con, $categoria);

    // Verificando se foi fornecida uma imagem para upload
    if (is_array($imagem)) {
        $fotoAntiga = getFotoAntiga($slug, $con);  // Obtendo a imagem antiga
        $imagemNome = updateImage($fotoAntiga, $imagem);  // Atualizando a imagem

        if ($imagemNome !== false) {
            // Caso tenha nova imagem, atualiza o URL
            $imagemUrl = 'http://127.0.0.1:8080/uploads/postsImg/' . $imagemNome;
            $query = "UPDATE posts SET titulo = ?, subtitulo = ?, conteudo = ?, imagem_url = ?, categoria = ? WHERE slug = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("ssssss", $titulo, $subtitulo, $conteudo, $imagemUrl, $categoria, $slug);
        } else {
            return json_encode([
                'status' => 'error',
                'message' => 'Erro ao enviar a imagem',
                'codigo' => ''
            ]);
        }
    } else {
        // Caso não tenha imagem, apenas atualiza outros campos
        $query = "UPDATE posts SET titulo = ?, subtitulo = ?, conteudo = ?, categoria = ? WHERE slug = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sssss", $titulo, $subtitulo, $conteudo, $categoria, $slug);
    }

    // Executar a query
    if ($stmt->execute()) {
        return json_encode([
            'status' => 'success',
            'message' => 'Atualizado com sucesso',
            'codigo' => ''
        ]);
    } else {
        return json_encode([
            'status' => 'error',
            'message' => 'Erro ao atualizar',
            'codigo' => ''
        ]);
    }
}

function updateImage($fotoAntiga, $imagem) {
    $pastaDestino = '../../uploads/postsImg/';

    // Criando o diretório caso não exista
    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0777, true);
    }

    // Apagar a imagem antiga
    if ($fotoAntiga && file_exists($pastaDestino . $fotoAntiga)) {
        unlink($pastaDestino . $fotoAntiga);
    }

    $nomeArquivo = basename($imagem['name']);
    $nomeUnico = time() . '_' . $nomeArquivo;
    $caminhoFinal = $pastaDestino . $nomeUnico;

    // Movendo o arquivo para o diretório final
    if (move_uploaded_file($imagem['tmp_name'], $caminhoFinal)) {
        return $nomeUnico;
    } else {
        return false;
    }
}

function getFotoAntiga($slug, $con) {
    // Preparar a consulta para buscar a imagem antiga do post
    $query = "SELECT imagem_url FROM posts WHERE slug = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $slug);
    $stmt->execute();

    // Inicializando a variável $imagemUrl
    $imagemUrl = null;  // Definindo a variável antes de usá-la

    $stmt->bind_result($imagemUrl);  // Associando o resultado à variável $imagemUrl
    $stmt->fetch();  // Obtendo o valor da imagem_url

    // Verificar se foi encontrado o resultado
    if ($imagemUrl) {
        // Extrair o nome do arquivo da URL
        $foto = str_replace('http://127.0.0.1:8080/uploads/postsImg/', '', $imagemUrl);
        return $foto;
    } else {
        return null; // Caso não haja foto, retornar null
    }
}

if ($slug) {
    echo editPost($titulo, $subtitulo, $slug, $conteudo, $imagem, $categoria, $con);
}
