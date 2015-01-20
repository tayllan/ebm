<?php

require_once '../config.php';
require_once DIR_ROOT . 'view/template/html.php';
require_once DIR_ROOT . 'view/template/listagens.php';

abstract class BaseView {

    protected $controller;

    abstract protected function rotear();

    abstract protected function cadastrar();

    abstract protected function listar();

    abstract protected function construirTabela($linha);

    abstract protected function alterar();

    protected function deletar($apelidoDaTabela, $nomeColunaIdDaTabela, $nomeDaTabela) {
        $trueFalse = $this->controller->deletar(
            $_POST['deletar'], $nomeColunaIdDaTabela, $nomeDaTabela
        );

        $this->exibirMensagemDelecao(
            $apelidoDaTabela, $trueFalse
        );
    }

    protected function exibirMensagemCadastro($apelidoDaTabela, $trueFalse) {
        if ($trueFalse) {
            $this->exibirConteudo('<p class="ui green label">' . $apelidoDaTabela
                . MENSAGEM_CADASTRO_SUCESSO . '</p>');
        }
        else {
            $this->exibirConteudo(MENSAGEM_ERRO);
        }
    }

    protected function exibirMensagemDelecao($apelidoDaTabela, $trueFalse) {
        if ($trueFalse) {
            $this->exibirConteudo('<p class="ui green label">' . $apelidoDaTabela
                . MENSAGEM_DELECAO_SUCESSO . '</p>');
        }
        else {
            $this->exibirConteudo(MENSAGEM_ERRO);
        }
    }

}
