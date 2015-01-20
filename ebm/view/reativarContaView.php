<?php

require_once '../config.php';
require_once DIR_ROOT . 'view/template/html.php';
require_once DIR_ROOT . 'controller/reativarContaController.php';

class ReativarContaView {
    
    private $controller;
    
    public function __construct() {
        $this->controller = new ReativarContaController();
        $this->rotear();
    }
    
    private function rotear() {
        if (isset($_POST[Colunas::USUARIO_LOGIN])) {
            if ($this->controller->reativar()) {
                header('Location: /view/perfilView.php');
            }
            else {
                $this->exibirConteudo('<p class="ui red label">Conta não cadastrada<p>');
            }
        }
        else {
            $this->exibirConteudo(
                $this->controller->construirFormulario()
            );
        }
    }
    
    private function exibirConteudo($conteudo) {
        cabecalhoHTML('Tela de Reativacao de Conta');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }
    
}

new ReativarContaView();