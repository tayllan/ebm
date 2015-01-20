<?php

require_once '../config.php';
require_once DIR_ROOT . 'view/template/html.php';
require_once DIR_ROOT . 'controller/realizarCadastroController.php';
require_once DIR_ROOT . 'controller/loginController.php';
require_once DIR_ROOT . 'entity/usuarioModel.php';
require_once DIR_ROOT . 'view/template/realizarCadastroEdicao.php';

class RealizarCadastroView {
    
    private $controller;

    public function __construct() {
        $this->controller = new RealizarCadastroController();
        $this->rotear();
    }

    public function rotear() {
        if (isset($_POST[Colunas::USUARIO_NOME])) {
            if ($this->controller->inserir()) {
                $this->controller->logarRedirecionar();
            }
            else {
                $this->exibirConteudo(MENSAGEM_ERRO);
            }
        }
        else {
            $this->exibirConteudo(
                construirFormulario(Usuario::getNullObject())
            );
        }
    }
    
    public function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Usuários');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new RealizarCadastroView();
