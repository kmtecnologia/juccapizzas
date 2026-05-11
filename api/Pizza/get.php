<?php
// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET"); // Boa prática definir o método permitido

// Incluir arquivos de banco de dados e modelo
include_once '../../config/Database.php';
include_once '../../models/Pizza.php';

// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();

// Instanciar o objeto Pizza
$pizza = new Pizza($db);

// Captura o ID da URL
$pizza->idPizza = isset($_GET['id']) ? $_GET['id'] : null;

// 1. Verifica se o método é GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    // 2. Verifica se o ID foi enviado
    if ($pizza->idPizza) {
        
        // Tenta buscar a pizza (certifique-se que o método get() retorna true/false ou preenche os dados)
        if ($pizza->get() && $pizza->nome != null) {
            // Cria o array de resposta
            $pizza_arr = array(
                "id" => $pizza->idPizza,
                "nome" => $pizza->nome,
                "ingredientes" => $pizza->ingredientes,
                "valor" => $pizza->valor
            );

            http_response_code(200);
            echo json_encode($pizza_arr, JSON_PRETTY_PRINT);
        } else {
            // Caso o ID exista mas não foi encontrado no banco
            http_response_code(404);
            echo json_encode(array("Mensagem" => "Pizza não encontrada."));
        }

    } else {
        // Caso o ID não tenha sido enviado na URL
        http_response_code(400);
        echo json_encode(array("Mensagem" => "ID não informado."));
    }

} else {
    // Caso o método não seja GET
    http_response_code(405);
    echo json_encode(array("Mensagem" => "Método não permitido."));
}
?>