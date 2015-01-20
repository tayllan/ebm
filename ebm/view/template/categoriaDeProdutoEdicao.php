<?php

function construirFormulario($categoriaDeProduto) {
    $conteudo = '<form class="ui form" action="categoriaDeProdutoView.php" method="POST">
    <fieldset class="ui form segment">
        <legend>Informações Gerais</legend>
        
        <div>
            <label>Categoria</label>
            <div class="ui left labeled icon input field">
                <input type="text" name="' . Colunas::CATEGORIA_DE_PRODUTO_NOME
                . '" value="' . $categoriaDeProduto->nome . '">
                <i class="tag icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div>
            <button type="submit" name="submeter" class="ui black submit button small">
                <i class="save icon"></i>
                Salvar
            </button>
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::CATEGORIA_DE_PRODUTO_ID
                . '" value="' . $categoriaDeProduto->id . '">
        </div>
    </fieldset>
</form>
<script>
$(\'.ui.form\').form(
    {
        categoria: {
            identifier: "' . Colunas::CATEGORIA_DE_PRODUTO_NOME . '",
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