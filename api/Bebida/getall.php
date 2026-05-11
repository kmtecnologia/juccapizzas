<?php
// Criação rota getall.php para listar todas as bebidas cadastradas no banco de dados
 
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
 
// Verificar se o método de requisição é GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    // Chamar o método getall() para buscar as bebidas
    $stmt = $bebida->getall();
    $num = $stmt->rowCount();
 
    // Verificar se mais de 0 registros foram encontrados
    if ($num > 0) {
        // Array de bebidas
        $bebidas_arr = array();
 
        // Percorrer o resultado da consulta
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // A função extract transforma $row['nome'] em apenas $nome, etc.
            extract($row);
            
            // Criar um array associativo para cada bebida
            // Note que usamos idBebida e descricao conforme o modelo de bebidas
            $bebida_item = array(
                "id" => $idBebida,
                "nome" => $nome,
                "descricao" => $descricao,
                "valor" => $valor
            );
 
             array_push($bebidas_arr, $bebida_item); 
        }
 
        // Definir o código de resposta como 200 OK
        http_response_code(200);
 
        // Mostrar os dados das bebidas em formato JSON
        echo json_encode($bebidas_arr);
    } else {
        // Se nenhuma bebida for encontrada
        http_response_code(404);
 
        echo json_encode(
            array("message" => "Nenhuma bebida encontrada.")
        );
    }
} else {
    // Caso o método não seja GET
    http_response_code(405);
    echo json_encode(array("message" => "Método não permitido. Use GET."));
}