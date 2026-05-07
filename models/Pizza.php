<?php

class Pizza
{
    private $conn;
    private $tabela = "pizzas";
    public $idPizza;
    public $nome;
    public $ingredientes;
    public $valor;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Salvando a query em SQL em uma variável
    public function getall() {
        $query = "SELECT idPizza, nome, ingredientes, valor FROM " . $this->tabela;
        // Preparando a query para execução, ou seja, vinculando ela à conexão com o banco de dados
        $stmt = $this->conn->prepare($query);
        
        $stmt->execute(); // Executando a query no banco de dados
        
        return $stmt; // Retornando o resultado da query para ser usado em outro lugar 
     }

     public function get(){
        $query = 'SELECT
         idPizza,
         nome,
         ingredientes,
         valor
         FROM
         ' . $this->tabela . '
         WHERE
            idPizza = ? 
         LIMIT 1';
       
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idPizza);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Define as propriedades
        $this->nome = $row['nome'];
        $this->ingredientes = $row['ingredientes'];
        $this->valor = $row['valor'];

     }
     
       
}

