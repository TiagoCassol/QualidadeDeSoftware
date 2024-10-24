<?php
require 'functions.php';
use PHPUnit\Framework\TestCase;

class ComprasTest extends TestCase {
    private $compras;

    protected function setUp(): void {
        $this->compras = new Compras();
    }

    public function testeAdicionarItem() {
        $this->compras->adicionarItem('Ração para cães', 2);
        $this->compras->adicionarItem('Brinquedo para gatos', 1);

        $this->assertArrayHasKey('Ração para cães', $this->compras->getCarrinho());
        $this->assertArrayHasKey('Brinquedo para gatos', $this->compras->getCarrinho());

        $this->assertEquals(2, $this->compras->getCarrinho()['Ração para cães']);
        $this->assertEquals(1, $this->compras->getCarrinho()['Brinquedo para gatos']);
    }

    public function testeRemoverItemParcial() {
        $this->compras->adicionarItem('Ração para cães', 3);
        $this->compras->removerItem('Ração para cães', 1);

 
        $this->assertEquals(2, $this->compras->getCarrinho()['Ração para cães']);
    }

  
    public function testeRemoverItemCompleto() {
        $this->compras->adicionarItem('Brinquedo para gatos', 1);
        $this->compras->removerItem('Brinquedo para gatos');

        $this->assertArrayNotHasKey('Brinquedo para gatos', $this->compras->getCarrinho());
    }

    public function testeExibirCarrinhoVazio() {

        ob_start();
        $this->compras->exibirCarrinho();
        $output = ob_get_clean();

        $this->assertEquals("O carrinho está vazio.\n", $output);
    }
}

