
<?php

class Database
{

    private $host = 'localhost';
    private $db_name = 'jucapizzadb';
    private $username = 'root';
    private $password = 'usbw';
    private $port = '3306';

    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            
            // DSN (Data Source Name) - string de conexão
            $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db_name . ';charset=utf8';

            // Instancia o objeto PDO
            $this->conn = new PDO($dsn, $this->username, $this->password);

            // Lança exceções em caso de erro
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Opcional: desabilitar emulação de prepared statements
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            // Mensagem útil para debug; em produção registre em arquivo em vez de exibir
            echo 'Erro de conexão: ' . $e->getMessage();
            $this->conn = null;
        } catch (Throwable $e) {
            // Mensagem útil para debug; em produção registre em arquivo em vez de exibir
            echo 'Erro Genérico: ' . $e->getMessage();
            $this->conn = null;
        }

        return $this->conn;
    }
}
?>
