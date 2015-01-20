<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/loginController.php';
require_once DIR_ROOT . 'controller/boletoBancarioController.php';

class BoletoBancarioView {
    
    private $controller;
    
    public function __construct() {
        $this->controller = new BoletoBancarioController();
        if (LoginController::testarLogin()) {
            $this->rotear();
        }
    }
    
    private function rotear() {
        $array = $this->controller->listar();
        if (!empty($array)) {
            $this->exibirConteudo(
                '<div id="divBoleto">'
                . $this->controller->contruirBoletoBancario()
                . '</div>'
            );
        }
        else {
            $this->exibirConteudo('<p class="ui red label">Você não realizou nenhuma compra</p>');
        }        
    }

    private function exibirConteudo($conteudo) {
        cabecalhoHTML('Boleto Bancário');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }
    
}

new BoletoBancarioView();