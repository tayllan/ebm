<?php

function construirFormulario($itemDeProduto) {
    $compraController = new CompraController();
    $produtoController = new ProdutoController();
    $conteudo = '<form class="ui form" action="itemDeProdutoView.php" method="POST">
    <fieldset class="ui form segment">
        <legend>Informações Gerais</legend>
        
        <div>
            <label>Quantidade</label>
            <div class="ui left labeled icon input field">
                <input type="number" name="' . Colunas::ITEM_DE_PRODUTO_QUANTIDADE
                    . '" value="' . $itemDeProduto->quantidade . '">
                <i class="add icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label>Preço Unitário</label>
            <div class="ui left labeled icon input field">
                <input type="number" name="' . Colunas::ITEM_DE_PRODUTO_PRECO
                    . '" value="' . $itemDeProduto->preco . '">
                <i class="dollar icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div class="ui segment">
            <i class="icon"></i>
            <label>Compra:</label>
            <select name="' . Colunas::ITEM_DE_PRODUTO_FK_COMPRA . '" size="1">';
    $arrayCompra = $compraController->listar(Colunas::COMPRA);
    foreach ($arrayCompra as $linha) {
        $conteudo .= '<option value="' . $linha[Colunas::COMPRA_ID] . '"';
        if ($linha[Colunas::COMPRA_ID] === $itemDeProduto->compra->id) {
            $conteudo .= ' selected';
        }
        $conteudo .= '>' . $linha[Colunas::COMPRA_DATA] . ' '
            . $linha[Colunas::COMPRA_TOTAL] . '</option>';
    }
    $conteudo .= '</select>
            <div class="ui red corner label">
                <i class="icon asterisk"></i>
            </div>
        </div>
        
        <div class="ui segment">
            <i class="cart icon"></i>
            <label>Produto:</label>
            <select name="' . Colunas::ITEM_DE_PRODUTO_FK_PRODUTO. '" size="1">';
    $arrayProduto = $produtoController->listar(Colunas::PRODUTO);
    foreach ($arrayProduto as $linha) {
        $conteudo .= '<option value="' . $linha[Colunas::PRODUTO_ID] . '"';
        if ($linha[Colunas::PRODUTO_ID] === $itemDeProduto->produto->id) {
            $conteudo .= ' selected';
        }
        $conteudo .= '>' . $linha[Colunas::PRODUTO_NOME] . '</option>';
    }
    $conteudo .= '</select>
            <div class="ui red corner label">
                <i class="icon asterisk"></i>
            </div>
        </div>
        
        <div>
            <button type="submit" name="submeter" class="ui black submit button small">
                <i class="save icon"></i>
                Salvar
            </button>
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::ITEM_DE_PRODUTO_ID . '" value="' . $itemDeProduto->id . '">
        </div>
    </fieldset>
</form>
<script>
$(\'.ui.form\').form(
    {
        quantidade: {
            identifier: "' . Colunas::ITEM_DE_PRODUTO_QUANTIDADE . '",
            rules: [
                emptyRule
          ]
        },
        preco: {
            identifier: "' . Colunas::ITEM_DE_PRODUTO_PRECO . '",
            rules: [
                emptyRule
          ]
        }
    },
    {
        inline: true
    }
);
</script>';
            
    return $conteudo;
}