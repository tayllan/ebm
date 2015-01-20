<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/loginController.php';
require_once DIR_ROOT . 'controller/cartaoDeCreditoController.php';

class CartaoDeCreditoView {
    
    private $controller;
    
    public function __construct() {
        $this->controller = new CartaoDeCreditoController();
        if (LoginController::testarLogin()) {
            $this->rotear();
        }
    }
    
    private function rotear() {
        if (isset($_POST['compraSucesso'])) {
            $this->exibirConteudo('<p class="ui green label">Compra Efetuada com sucesso!</p>');
            $this->controller->finalizarCompra();
        }
        else {
            $this->exibirConteudo($this->controller->construirFormularioCartao());
        }
    }

    private function exibirConteudo($conteudo) {
        cabecalhoHTML('Cartão de Crédito');
        cabecalho('Super Cabeçalho');
        echo '<div>' . $conteudo . '</div>';
        rodape('Super Rodapé');
        rodapeHTML();
    }
    
}

new CartaoDeCreditoView();