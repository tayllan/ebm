<?php

require_once 'baseView.php';
require_once DIR_ROOT . 'controller/categoriaDeProdutoController.php';
require_once DIR_ROOT . 'entity/categoriaDeProdutoModel.php';
require_once DIR_ROOT . 'view/template/categoriaDeProdutoEdicao.php';

class CategoriaDeProdutoView extends BaseView {

    public function __construct() {
        $this->controller = new CategoriaDeProdutoController();
        if ($this->controller->testarLoginAdministrador()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::CATEGORIA_DE_PRODUTO_ID])) {
            $categoriaDeProduto = $this->controller->construirObjeto(
                array (
                    Colunas::CATEGORIA_DE_PRODUTO_ID => $_POST[Colunas::CATEGORIA_DE_PRODUTO_ID],
                    Colunas::CATEGORIA_DE_PRODUTO_NOME => $_POST[Colunas::CATEGORIA_DE_PRODUTO_NOME]
                )
            );
            $trueFalse = $this->controller->rotearInsercao($categoriaDeProduto);
            $this->exibirMensagemCadastro(
                'Categoria de Produto', $trueFalse
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
                'Categoria de Produto', Colunas::CATEGORIA_DE_PRODUTO_ID,
                Colunas::CATEGORIA_DE_PRODUTO
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $categoriaDeProduto = CategoriaDeProduto::getNullObject();
        $this->exibirConteudo(
            construirFormulario($categoriaDeProduto)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::CATEGORIA_DE_PRODUTO);
        $conteudo = criarTabela(
            'Categorias de Produtos Cadastradas', 'categoriaDeProdutoView',
            array('Nome')
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table></form><script>paginarTabela()</script>');
    }
    
    protected function construirTabela($linha) {
        $conteudo = '<tr><td><button type="submit" name="editar" '
            . 'value="' . $linha[Colunas::CATEGORIA_DE_PRODUTO_ID] . '" '
            . 'class="ui black submit button small"><i class="edit icon"></i></button></td>'
            . '<td>' . $linha[Colunas::CATEGORIA_DE_PRODUTO_NOME] . '</td>'
            . '<td><button type="submit" name="deletar" '
            . 'value="' . $linha[Colunas::CATEGORIA_DE_PRODUTO_ID] . '" '
            . 'class="ui red submit button small" onclick="return confirmarDelecao()">'
            . '<i class="delete icon"></i></button></td></tr>';
        
        return $conteudo;
    }

    protected function alterar() {
        $categoriaDeProduto = $this->controller->construirObjetoPorId($_POST['editar']);
        
        $this->exibirConteudo(
            construirFormulario($categoriaDeProduto)
        );
    }
    
    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Categorias de Produtos');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new CategoriaDeProdutoView();
