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

     public function get() {
      $query = 'SELECT idPizza, nome, ingredientes, valor FROM ' . $this->tabela . ' WHERE idPizza = ? LIMIT 1';
      
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->idPizza);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if ($row) {
          $this->nome = $row['nome'];
          $this->ingredientes = $row['ingredientes'];
          $this->valor = $row['valor'];
          return true; // Retorna true se encontrou
      }
      
      return false; // Retorna false se não encontrou
  }
     public function add() {
      $query = 'INSERT INTO ' . $this->tabela . ' SET nome = :nome, ingredientes = :ingredientes, valor = :valor';
      
      $stmt = $this->conn->prepare($query);
      
      // Limpa os dados
      $this->nome=htmlspecialchars(strip_tags($this->nome));
      $this->ingredientes=htmlspecialchars(strip_tags($this->ingredientes));
      $this->valor=htmlspecialchars(strip_tags($this->valor));
      
      // Bind dos dados
      $stmt->bindParam(':nome', $this->nome);
      $stmt->bindParam(':ingredientes', $this->ingredientes);
      $stmt->bindParam(':valor', $this->valor);
      
      if($stmt->execute()) {
          return true;
      }
      
      return false;
   }
   public function update() {
    // Query de atualização
    $query = 'UPDATE ' . $this->tabela . ' SET nome=:nome, ingredientes=:ingredientes, valor=:valor WHERE idPizza=:id';

    // Preparar a query
    $stmt = $this->conn->prepare($query);

    // Limpar os dados
    $this->nome = htmlspecialchars(strip_tags($this->nome));
    $this->ingredientes = htmlspecialchars(strip_tags($this->ingredientes));
    $this->valor = htmlspecialchars(strip_tags($this->valor));
    $this->idPizza = htmlspecialchars(strip_tags($this->idPizza));

    // Vincular os parâmetros
    $stmt->bindParam(':nome', $this->nome);
    $stmt->bindParam(':ingredientes', $this->ingredientes);
    $stmt->bindParam(':valor', $this->valor);
    $stmt->bindParam(':id', $this->idPizza);

    // Executar a query
    if($stmt->execute()) {
        return true;
    }
 
    return false;
}
public function delete() {
 
    // Query DELETE
    $query = 'DELETE FROM ' . $this->tabela . ' WHERE idPizza = :id';

    // Preparar query
    $stmt = $this->conn->prepare($query);

    // Limpar dados
    $this->idPizza = htmlspecialchars(strip_tags($this->idPizza));

    // Vincular parâmetro
    $stmt->bindParam(':id', $this->idPizza);

    // Executar query
    if($stmt->execute()) {
        return true;
    }

    return false;
}
}