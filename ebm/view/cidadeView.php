<?php

require_once 'baseView.php';
require_once DIR_ROOT . 'controller/cidadeController.php';
require_once DIR_ROOT . 'controller/unidadeFederativaController.php';
require_once DIR_ROOT . 'entity/cidadeModel.php';
require_once DIR_ROOT . 'entity/unidadeFederativaModel.php';
require_once DIR_ROOT . 'view/template/cidadeEdicao.php';

class CidadeView extends BaseView {

    public function __construct() {
        $this->controller = new CidadeController();
        if ($this->controller->testarLoginAdministrador()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::CIDADE_ID])) {
            $cidade = $this->controller->construirObjeto(
                array (
                    Colunas::CIDADE_ID => $_POST[Colunas::CIDADE_ID],
                    Colunas::CIDADE_NOME => $_POST[Colunas::CIDADE_NOME],
                    Colunas::CIDADE_FK_UNIDADE_FEDERATIVA => $_POST[Colunas::CIDADE_FK_UNIDADE_FEDERATIVA]
                )
            );
            $trueFalse = $this->controller->rotearInsercao($cidade);
            $this->exibirMensagemCadastro(
                'Cidade', $trueFalse
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
                'Cidade', Colunas::CIDADE_ID,
                Colunas::CIDADE
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $cidade = Cidade::getNullObject();
        $this->exibirConteudo(
            construirFormulario($cidade)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::CIDADE);
        $conteudo = criarTabela(
            'Cidades Cadastradas', 'cidadeView',
            array(
                'Nome', 'Unidade Federativa'
            )
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table></form><script>paginarTabela()</script>');
    }
    
    protected function construirTabela($linha) {
        $conteudo = '<tr><td><button type="submit" name="editar" '
            . 'value="' . $linha[Colunas::CIDADE_ID] . '" '
            . 'class="ui black submit button small"><i class="edit icon"></i></button></td>'
            . '<td>' . $linha[Colunas::CIDADE_NOME] . '</td>'
            . '<td>' . $this->controller->getStateName($linha) . '</td>'
            . '<td><button type="submit" name="deletar" '
            . 'value="' . $linha[Colunas::CIDADE_ID] . '" '
            . 'class="ui red submit button small" onclick="return confirmarDelecao()">'
            . '<i class="delete icon"></i></button></td></tr>';
        
        return $conteudo;
    }

    protected function alterar() {
        $cidade = $this->controller->construirObjetoPorId($_POST['editar']);

        $this->exibirConteudo(
            construirFormulario($cidade)
        );
    }
    
    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Cidades');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new CidadeView();
