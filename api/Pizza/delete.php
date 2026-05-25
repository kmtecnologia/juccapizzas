<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
 
include_once '../../config/Database.php';
include_once '../../models/Pizza.php';
 
// Instanciar o banco de dados e conectar
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pizza
$pizza = new Pizza($db);
 
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
 
    try {
 
        // Obter os dados enviados
        $data = json_decode(file_get_contents("php://input"));
 
        // Verificar se o ID foi informado
        if (!empty($data->id)) {
 
            // Atribuir o ID do JSON à propriedade interna da classe Pizza
            $pizza->idPizza = $data->id;
 
            // NOVO: Verificar se a pizza realmente existe antes de deletar
            if ($pizza->get()) {
 
                // Se existe, tenta deletar
                if ($pizza->delete()) {
                    http_response_code(200);
                    echo json_encode(
                        array('Mensagem' => 'Pizza deletada com sucesso')
                    );
                } else {
                    http_response_code(500);
                    echo json_encode(
                        array('Mensagem' => 'Nao foi possivel deletar a Pizza')
                    );
                }
 
            } else {
                // ERRO 404: Pizza não foi encontrada no banco de dados
                http_response_code(404);
                echo json_encode(
                    array('Mensagem' => 'Pizza nao encontrada. ID inexistente.')
                );
            }
 
        } else {
            http_response_code(400);
            echo json_encode(
                array('Mensagem' => 'Dados incompletos. ID da Pizza nao informado.')
            );
        }
 
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(
            array("erro" => $e->getMessage())
        );
    }
 
} else {
    http_response_code(405);
    echo json_encode(
        array("erro" => "Método não suportado!")
    );
}