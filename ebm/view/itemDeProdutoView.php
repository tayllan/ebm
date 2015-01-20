<?php

require_once 'baseView.php';
require_once DIR_ROOT . 'controller/itemDeProdutoController.php';
require_once DIR_ROOT . 'controller/compraController.php';
require_once DIR_ROOT . 'controller/produtoController.php';
require_once DIR_ROOT . 'entity/itemDeProdutoModel.php';
require_once DIR_ROOT . 'entity/compraModel.php';
require_once DIR_ROOT . 'entity/produtoModel.php';
require_once DIR_ROOT . 'view/template/itemDeProdutoEdicao.php';

class ItemDeProdutoView extends BaseView {

    public function __construct() {
        $this->controller = new ItemDeProdutoController();
        if ($this->controller->testarLoginAdministrador()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::ITEM_DE_PRODUTO_ID])) {
            $itemDeProduto = $this->controller->construirObjeto(
                array (
                    Colunas::ITEM_DE_PRODUTO_ID => $_POST[Colunas::ITEM_DE_PRODUTO_ID],
                    Colunas::ITEM_DE_PRODUTO_QUANTIDADE => $_POST[Colunas::ITEM_DE_PRODUTO_QUANTIDADE],
                    Colunas::ITEM_DE_PRODUTO_PRECO => $_POST[Colunas::ITEM_DE_PRODUTO_PRECO],
                    Colunas::ITEM_DE_PRODUTO_FK_COMPRA => $_POST[Colunas::ITEM_DE_PRODUTO_FK_COMPRA],
                    Colunas::ITEM_DE_PRODUTO_FK_PRODUTO => $_POST[Colunas::ITEM_DE_PRODUTO_FK_PRODUTO]
                )
            );
            $trueFalse = $this->controller->rotearInsercao($itemDeProduto);
            $this->exibirMensagemCadastro(
                'Item De Prdotuo', $trueFalse
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
                'Item De Produto', Colunas::ITEM_DE_PRODUTO_ID,
                Colunas::ITEM_DE_PRODUTO
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $itemDeProduto = ItemDeProduto::getNullObject();
        $this->exibirConteudo(
            construirFormulario($itemDeProduto)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::ITEM_DE_PRODUTO);
        $conteudo = criarTabela(
            'Itens de Produtos Cadastrados', 'itemDeProdutoView',
            array(
                'Quantidade', 'Preço',
                'Compra Relacionada', 'Produto'
            )
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table></form><script>paginarTabela()</script>');
    }
    
    protected function construirTabela($linha) {
        $conteudo = '<tr><td><button type="submit" name="editar" '
            . 'value="' . $linha[Colunas::ITEM_DE_PRODUTO_ID] . '" '
            . 'class="ui black submit button small"><i class="edit icon"></i></button></td>'
            . '<td>' . $linha[Colunas::ITEM_DE_PRODUTO_QUANTIDADE] . '</td>'
            . '<td>' . $linha[Colunas::ITEM_DE_PRODUTO_PRECO] . '</td>'
            . '<td>' . $this->controller->getBuyName($linha) . '</td>'
            . '<td>' . $this->controller->getProductName($linha) . '</td>'
            . '<td><button type="submit" name="deletar" '
            . 'value="' . $linha[Colunas::ITEM_DE_PRODUTO_ID] . '" '
            . 'class="ui red submit button small" onclick="return confirmarDelecao()">'
            . '<i class="delete icon"></i></button></td></tr>';
        
        return $conteudo;
    }

    protected function alterar() {
        $itemDeProduto = $this->controller->construirObjetoPorId($_POST['editar']);

        $this->exibirConteudo(
            construirFormulario($itemDeProduto)
        );
    }
    
    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Itens de Produtos');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new ItemDeProdutoView();