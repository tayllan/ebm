<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/perfilController.php';
require_once DIR_ROOT . 'view/template/html.php';

class PerfilView {
    
    private $controller;
    
    public function __construct() {
        $this->controller = new PerfilController();
        $this->rotear();
    }
    
    public function rotear() {
        if (isset($_POST['minhasCompras'])) {
            $this->exibirConteudo(
                $this->controller->construirMenuDeCompras()
            );
        }
        else if (isset($_POST['meusDados'])) {
            $this->exibirConteudo(
                $this->controller->alterar()
            );
        }
        else if (isset($_POST['deletarConta'])) {
            $this->controller->desativarUsuario();
        }
        else {
            $this->exibirConteudo(
                $this->construirMenu()
            );
        }
    }
    
    private function construirMenu() {
        $menu = '<form action="/view/perfilView.php" method="POST">
            <div class="ui center aligned segment">
                <div class="ui secondary  menu small">
                    <button type="submit" class="item" name="minhasCompras">
                        <i class="cart icon"></i>
                        Minhas Compras
                    </button>
                    <button type="submit" class="item" name="meusDados">
                        <i class="edit icon"></i>
                        Editar Meus Dados
                    </button>
                    <button type="submit" class="item" name="deletarConta" onclick="return confirmarDelecao()">
                        <i class="delete icon"></i>
                        Deletar Conta
                    </button>
                </div>
            </div>
        </form>';
        
        return $menu;
    }
    
    private function exibirConteudo($conteudo) {
        cabecalhoHTML('Meu Perfil');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }
    
}

new PerfilView();