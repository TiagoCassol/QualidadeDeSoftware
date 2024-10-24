
<?php
require 'functions.php';
use PHPUnit\Framework\TestCase; 

class LoginTest extends TestCase { 
   
    public function testeLoginFeitoComSucesso() {
        $dbConnection = $this->createMock(PDO::class);
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetch') 
            ->willReturn(['email' => 'test@example.com', 'password' => 'password123']);

        $dbConnection->method('prepare') 
            ->willReturn($stmt);

        $login = new Login($dbConnection);

        $result = $login->login('test@example.com', 'password123');

        $this->assertTrue($result);
    }
    public function testeLoginNaoRealizado() {
        $dbConnection = $this->createMock(PDO::class);

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetch') 
            ->willReturn(false);


        $dbConnection->method('prepare') 
            ->willReturn($stmt);

        $login = new Login($dbConnection);

        $result = $login->login('hfghfg@exjkh.com', 'hkjhkyu');
        $this->assertFalse($result);
    }
      public function testeRegistradoNovoUsuario() {
        $dbConnection = $this->createMock(PDO::class);
        
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')
            ->willReturn(true);

        $dbConnection->method('prepare')
            ->willReturn($stmt);

        $login = new Login($dbConnection);

        $result = $login->register('Test User', 'test@example.com', 'password123');

        $this->assertTrue($result);
    }
}

