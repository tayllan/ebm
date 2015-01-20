<?php

require_once 'baseView.php';
require_once DIR_ROOT . 'controller/marcaDeProdutoController.php';
require_once DIR_ROOT . 'entity/marcaDeProdutoModel.php';
require_once DIR_ROOT . 'view/template/marcaDeProdutoEdicao.php';

class MarcaDeProdutoView extends BaseView {

    public function __construct() {
        $this->controller = new MarcaDeProdutoController();
        if ($this->controller->testarLoginAdministrador()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::MARCA_DE_PRODUTO_ID])) {
            $marcaDeProduto = $this->controller->construirObjeto(
                array (
                    Colunas::MARCA_DE_PRODUTO_ID => $_POST[Colunas::MARCA_DE_PRODUTO_ID],
                    Colunas::MARCA_DE_PRODUTO_NOME=> $_POST[Colunas::MARCA_DE_PRODUTO_NOME]
                )
            );
            $trueFalse = $this->controller->rotearInsercao($marcaDeProduto);
            $this->exibirMensagemCadastro(
                'Marca de Produto', $trueFalse
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
                'Marca de Produto', Colunas::MARCA_DE_PRODUTO_ID,
                Colunas::MARCA_DE_PRODUTO
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $marcaDeProduto = MarcaDeProduto::getNullObject();
        $this->exibirConteudo(
            construirFormulario($marcaDeProduto)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::MARCA_DE_PRODUTO);
        $conteudo = criarTabela(
            'Marcas de Produtos Cadastradas', 'marcaDeProdutoView',
            array('Nome')
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table></form><script>paginarTabela()</script>');
    }
    
    protected function construirTabela($linha) {
        $conteudo = '<tr><td><button type="submit" name="editar" '
            . 'value="' . $linha[Colunas::MARCA_DE_PRODUTO_ID] . '" '
            . 'class="ui black submit button small"><i class="edit icon"></i></button></td>'
            . '<td>' . $linha[Colunas::MARCA_DE_PRODUTO_NOME] . '</td>'
            . '<td><button type="submit" name="deletar" '
            . 'value="' . $linha[Colunas::MARCA_DE_PRODUTO_ID] . '" '
            . 'class="ui red submit button small" onclick="return confirmarDelecao()">'
            . '<i class="delete icon"></i></button></td></tr>';
        
        return $conteudo;
    }

    protected function alterar() {
        $marcaDeProduto = $this->controller->construirObjetoPorId($_POST['editar']);

        $this->exibirConteudo(
            construirFormulario($marcaDeProduto)
        );
    }
    
    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Marcas de Produtos');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new MarcaDeProdutoView();