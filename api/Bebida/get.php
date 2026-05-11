<?php

// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// Incluir arquivos de banco de dados e modelo
include_once '../../config/Database.php';
include_once '../../models/Bebida.php'; // Alterado para o modelo de Bebida
 
// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Bebida
$bebida = new Bebida($db);
 
// Captura o ID enviado via URL (ex: get.php?id=1)
$bebida->idBebida = isset($_GET['id']) ? $_GET['id'] : null;
 
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($bebida->idBebida) {
        // Busca a bebida no banco através do método get() definido no model
        $bebida->get();
 
        // Verifica se a bebida foi realmente encontrada (se o nome foi preenchido)
        if ($bebida->nome != null) {
            // Cria o array de resposta
            $bebida_arr = array(
                "id" => $bebida->idBebida,
                "nome" => $bebida->nome,
                "descricao" => $bebida->descricao,
                "valor" => $bebida->valor
            );
 
            // Define o código 200 OK e exibe o JSON
            http_response_code(200);
            echo json_encode($bebida_arr, JSON_PRETTY_PRINT);
        } else {
            // Caso o ID não exista no banco
            http_response_code(404);
            echo json_encode(array("Mensagem" => "Bebida não encontrada."));
        }
    } else {
        // Caso o parâmetro 'id' não tenha sido passado na URL
        http_response_code(400);
        echo json_encode(array("Mensagem" => "ID não fornecido."));
    }
} else {
    // Caso tentem usar POST, PUT, DELETE, etc.
    http_response_code(405);
    echo json_encode(array("Mensagem" => "Método não permitido."));
}