<?php
 
require_once "models/Bebida.php";
require_once "config/Database.php";
// Inserir referência para as classes que serão usadas
 
echo "<h1>Testando Conexão e Modelo Bebida</h1>";
 
$database = new Database();
$db = $database->getConnection();
 
if (!$db) {
    echo "<p style='color: red;'>Falha na conexão.</p>";
    die(); // Encerra o script se não houver conexão
}
 
echo "<p style='color: green;'>Conexão bem-sucedida!</p>";
 
echo "<h2>Criando um objeto Bebida...</h2>";
 
// Criamos uma instância da classe Bebida, passando a conexão com o banco
$bebida = new Bebida($db);
 
// Atribuímos valores às suas propriedades públicas para teste manual
$bebida->nome = 'Guaraná Antarctica';
$bebida->descricao = 'Lata 350ml';
$bebida->valor = 5.50;
 
// Vamos inspecionar o objeto!
echo "<pre>"; // A tag <pre> ajuda a formatar a saída do print_r
print_r($bebida);
echo "</pre>";

echo "<h2>Testando método getall()...</h2>";
$stmt = $bebida->getall();
$total = $stmt->rowCount();
echo "<p>Total de bebidas encontradas no banco: <strong>$total</strong></p>";