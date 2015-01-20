<?php

require_once 'baseView.php';
require_once DIR_ROOT . 'controller/regiaoController.php';
require_once DIR_ROOT . 'entity/regiaoModel.php';
require_once DIR_ROOT . 'view/template/regiaoEdicao.php';

class RegiaoView extends BaseView {

    public function __construct() {
        $this->controller = new RegiaoController();
        if ($this->controller->testarLoginAdministrador()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::REGIAO_ID])) {
            $regiao = $this->controller->construirObjeto(
                array(
                    Colunas::REGIAO_ID => $_POST[Colunas::REGIAO_ID],
                    Colunas::REGIAO_NOME => $_POST[Colunas::REGIAO_NOME]
                )
            );
            $trueFalse = $this->controller->rotearInsercao($regiao);
            $this->exibirMensagemCadastro(
                'Região', $trueFalse
            );
        }
        else if (isset($_POST['editar']) && $_POST['editar'] === 'false') {
            $this->cadastrar();
        }
        else if (isset($_POST['editar'])) {
            $this->alterar();
        }
        else if (isset($_POST['deletar'])) {
            $this->deletar(
                'Região', Colunas::REGIAO_ID, Colunas::REGIAO
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $regiao = Regiao::getNullObject();
        $this->exibirConteudo(
            construirFormulario($regiao)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::REGIAO);
        $conteudo = criarTabela(
            'Regiões Cadastradas', 'regiaoView',
            array('Nome')
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table></form><script>paginarTabela()</script>');
    }

    protected function construirTabela($linha) {
        $conteudo = '<tr><td><button type="submit" name="editar" '
            . 'value="' . $linha[Colunas::REGIAO_ID] . '" class="ui black submit button small">'
            . '<i class="edit icon"></i></button></td>'
            . '<td>' . $linha[Colunas::REGIAO_NOME] . '</td>'
            . '<td><button type="submit" name="deletar" '
            . 'value="' . $linha[Colunas::REGIAO_ID]
            . '" class="ui red submit button small" onclick="return confirmarDelecao()">'
            . '<i class="delete icon"></i></button></td></tr>';

        return $conteudo;
    }

    protected function alterar() {
        $regiao = $this->controller->construirObjetoPorId($_POST['editar']);

        $this->exibirConteudo(
            construirFormulario($regiao)
        );
    }

    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Regiões');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new RegiaoView();
