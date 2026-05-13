<?php

class Bebida
{
    private $conn;
    private $tabela = "bebidas";
    
    // Propriedades da classe (refletem as colunas do banco de dados)
    public $idBebida;
    public $nome;
    public $descricao;
    public $valor;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Retorna todos os registros da tabela
    public function getall() {
        $query = "SELECT idBebida, nome, descricao, valor FROM " . $this->tabela;
        
        // Preparando a query para execução
        $stmt = $this->conn->prepare($query);
        
        // Executando a query no banco de dados
        $stmt->execute(); 
        
        // Retornando o resultado da query
        return $stmt; 
    }

    // Retorna um registro específico baseado no ID
    public function get(){
        $query = 'SELECT
         idBebida,
         nome,
         descricao,
         valor
         FROM
         ' . $this->tabela . '
         WHERE
            idBebida = ? 
         LIMIT 1';
       
        $stmt = $this->conn->prepare($query);
        
        // Vincula o ID passado à classe (bind) ao ponto de interrogação na query
        $stmt->bindParam(1, $this->idBebida);
        $stmt->execute();
        
        // Extrai a linha de resultado como um array associativo
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Define as propriedades do objeto com os dados retornados do banco
        if($row) {
            $this->nome = $row['nome'];
            $this->descricao = $row['descricao'];
            $this->valor = $row['valor'];
        }
    }
    public function add() {
        // 1. Correção no nome da coluna: era 'dercricao', o correto é 'descricao'
        $query = 'INSERT INTO ' . $this->tabela . ' SET nome = :nome, descricao = :descricao, valor = :valor';
        
        $stmt = $this->conn->prepare($query);
        
        // Limpa os dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
        
        // 2. Correção no Bind: o placeholder deve ser ':descricao' para bater com a query
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':valor', $this->valor);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
       
}
?>