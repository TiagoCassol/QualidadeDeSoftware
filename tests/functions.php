<?php
$server = "localhost";
$userDb = "root";
$passDb = "12345";
$nameDb = "petshop";
$port = 3306;

$connect = mysqli_connect($server, $userDb, $passDb, $nameDb, $port);

if (!$connect) {
    die("Falha na conexão: " . mysqli_connect_error());
}

class Login {
    // Atributo que armazena a conexão com o banco de dados
    private $dbConnection;
    // Construtor da classe que recebe a conexão do banco de dados
    public function __construct($dbConnection) {
        $this->dbConnection = $dbConnection; // Inicializa a propriedade $dbConnection com a conexão fornecida
    }
    // Método para realizar o login com e-mail e senha
    public function login($email, $password) {

        // A consulta utiliza placeholders (?) para evitar injeções SQL
        $query = "SELECT * FROM users WHERE email = ? AND password = ?";
        
        // Prepara a consulta SQL
        $stmt = $this->dbConnection->prepare($query);
        
        // Executa a consulta com os parâmetros fornecidos (email e password)
        $stmt->execute([$email, $password]);
        
        // Recupera o resultado da consulta
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user'] = $user;
            return true; 
        }
        return false;
    }
    public function register($name, $email, $password) {
    
        $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->dbConnection->prepare($query);
        return $stmt->execute([$name, $email, $password]);
    }

}

class Compras {
    private $carrinho = [];


    public function adicionarItem($item, $quantidade) {
        // Verifica se o item já está no carrinho
        if (isset($this->carrinho[$item])) {
            $this->carrinho[$item] += $quantidade;
        } else {
            $this->carrinho[$item] = $quantidade;
        }
        echo "$quantidade unidades de $item foram adicionadas ao carrinho.\n";
    }


    public function removerItem($item, $quantidade = null) {
        if (isset($this->carrinho[$item])) {
            // Se a quantidade não for especificada ou igual à quantidade no carrinho, remove o item totalmente
            if ($quantidade === null || $this->carrinho[$item] <= $quantidade) {
                unset($this->carrinho[$item]);
                echo "$item foi removido do carrinho.\n";
            } else {
                $this->carrinho[$item] -= $quantidade;
                echo "$quantidade unidades de $item foram removidas do carrinho.\n";
            }
        } else {
            echo "$item não está no carrinho.\n";
        }
    }
    public function exibirCarrinho() {
        if (empty($this->carrinho)) {
            echo "O carrinho está vazio.\n";
        } else {
            echo "Itens no carrinho:\n";
            foreach ($this->carrinho as $item => $quantidade) {
                echo "- $item: $quantidade unidades\n";
            }
        }
    }

    public function getCarrinho() {
        return $this->carrinho;
    }
}





