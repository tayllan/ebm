<?php

function construirFormulario($compra) {
    $controller = new CompraController();
    $conteudo = '<form class="ui form" action="compraView.php" method="POST">
    <fieldset class="ui form segment">
        <legend>Informações Gerais</legend>
        
        <div>
            <label>Data em que foi realizada</label>
            <div class="ui left labeled icon input field">
                <input type="date" name="' . Colunas::COMPRA_DATA . '" value="' . $compra->data . '">
                <i class="calendar icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label>Valor Total</label>
            <div class="ui left labeled icon input field">
                <input type="number" name="' . Colunas::COMPRA_TOTAL . '" value="' . $compra->total . '">
                <i class="dollar icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label>Valor do Frete</label>
            <div class="ui left labeled icon input field">
                <input type="number" name="' . Colunas::COMPRA_FRETE . '" value="' . $compra->frete . '">
                <i class="dollar icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div class="ui segment">
            <i class="user icon"></i>
            <label>Comprador:</label>
            <select name="' . Colunas::COMPRA_FK_USUARIO . '" size="1">';
    $array = $controller->listar(Colunas::USUARIO);
    foreach ($array as $linha) {
        if ($linha[Colunas::USUARIO_NOME] != 'USUARIO_ANONIMO') {
            $conteudo .= '<option value="' . $linha[Colunas::USUARIO_ID] . '"';
            if ($linha[Colunas::USUARIO_ID] === $compra->usuario->id) {
                $conteudo .= ' selected';
            }
            $conteudo .= '>' . $linha[Colunas::USUARIO_NOME] . '</option>';
        }
    }
    $conteudo .= '</select>
            <div class="ui red corner label">
                <i class="icon asterisk"></i>
            </div>
        </div>
        
        <div class="ui segment">
            <i class="icon"></i>
            <label>Concluida ?</label>
            <select size="1" name="' . Colunas::COMPRA_CONCLUIDA . '">';
    if ($compra->concluida) {
        $conteudo .= '<option value="true" selected>SIM</option>
                <option value="false">NÃO</option>';
    }
    else {
        $conteudo .= '<option value="true">SIM</option>
                <option value="false" selected>NÃO</option>';
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
            <input type="text" name="' . Colunas::COMPRA_ID . '" value="' . $compra->id . '">
        </div>
    </fieldset>
</form>
<script>
$(\'.ui.form\').form(
    {
        date: {
            identifier: "' . Colunas::COMPRA_DATA . '",
            rules: [
                emptyRule
          ]
        },
        valor: {
            identifier: "' . Colunas::COMPRA_TOTAL . '",
            rules: [
                emptyRule
          ]
        },
        frete: {
            identifier: "' . Colunas::COMPRA_FRETE . '",
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

function ajustarConclusao($concluida) {
    if ($concluida) {
        return 'SIM';
    }
    else {
        return 'NÃO';
    }
}