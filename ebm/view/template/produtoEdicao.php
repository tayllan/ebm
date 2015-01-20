<?php

function construirFormulario($produto) {
    $controller = new ProdutoController();
    $conteudo = '<form class="ui form" action="produtoView.php" 
        method="POST" enctype="multipart/form-data">
    <fieldset class="ui form segment">
        <legend>Informações Gerais</legend>
        
        <div>
            <label>Produto</label>
            <div class="ui left labeled icon input field">
                <input type="text" name="' . Colunas::PRODUTO_NOME . '" value="' . $produto->nome . '">
                <i class="cart icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div class="ui segment">
            <i class="tag icon"></i>
            <label>Marca</label>
            <select name="' . Colunas::PRODUTO_FK_MARCA. '" size="1">';
    $arrayMarca = $controller->listar(Colunas::MARCA_DE_PRODUTO);
    foreach ($arrayMarca as $linha) {
        $conteudo .= '<option value="' . $linha[Colunas::MARCA_DE_PRODUTO_ID] . '"';
        if ($linha[Colunas::MARCA_DE_PRODUTO_ID] === $produto->marca->id) {
            $conteudo .= ' selected';
        }
        $conteudo .= '>' . $linha[Colunas::MARCA_DE_PRODUTO_NOME] . '</option>';
    }
    $conteudo .= '</select>
            <div class="ui red corner label">
                <i class="icon asterisk"></i>
            </div>
        </div>
        
        <div class="ui segment">
            <i class="tag icon"></i>
            <label>Categoria</label>
            <select name="' . Colunas::PRODUTO_FK_CATEGORIA . '" size="1">';
    $arrayCategoria = $controller->listar(Colunas::CATEGORIA_DE_PRODUTO);
    foreach ($arrayCategoria as $linha) {
        $conteudo .= '<option value="' . $linha[Colunas::CATEGORIA_DE_PRODUTO_ID] . '"';
        if ($linha[Colunas::CATEGORIA_DE_PRODUTO_ID] === $produto->categoria->id) {
            $conteudo .= ' selected';
        }
        $conteudo .= '>' . $linha[Colunas::CATEGORIA_DE_PRODUTO_NOME] . '</option>';
    }
    $conteudo .= '</select>
            <div class="ui red corner label">
                <i class="icon asterisk"></i>
            </div>
        </div>
        
        <div>
            <label>Descrição</label>
            <div class="ui left labeled icon input field">
                <input type="text" name="' . Colunas::PRODUTO_DESCRICAO
                    . '" value="' . $produto->descricao . '">
            </div>
        </div>
        
        <div>
            <label>Preço</label>
            <div class="ui left labeled icon input field">
                <input type="number" name="' . Colunas::PRODUTO_PRECO . '" value="' . $produto->preco. '">
                <i class="dollar icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label>Quantidade</label>
            <div class="ui left labeled icon input field">
                <input type="number" name="' . Colunas::PRODUTO_QUANTIDADE
                    . '" value="' . $produto->quantidade . '">
                <i class="add icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label>Imagem</label>
            <div class="two fields">
                <div class="field ui left labeled icon input field">
                    <input type="text" name="' . Colunas::PRODUTO_IMAGEM
                        . '" value="' . $produto->caminhoImagem . '">
                    <i class="photo icon"></i>
                </div>
                <div class="field ui left labeled icon input">
                    <input type="file" name="imagem">
                    <i class="upload icon"></i>
                </div>
            </div>
        </div>
        
        <div>
            <br>
            <input type="submit" name="submeter" value="Salvar" class="ui black submit button small">
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::PRODUTO_ID . '" value="' . $produto->id . '">
        </div>
    </fieldset>
</form>
<script>
$(\'.ui.form\').form(
    {
        produto: {
            identifier: "' . Colunas::PRODUTO_NOME . '",
            rules: [
                emptyRule
          ]
        },
        preco: {
            identifier: "' . Colunas::PRODUTO_PRECO . '",
            rules: [
                emptyRule
          ]
        },
        quantidade: {
            identifier: "' . Colunas::PRODUTO_QUANTIDADE . '",
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