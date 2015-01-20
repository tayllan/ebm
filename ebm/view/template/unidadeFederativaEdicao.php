<?php

function construirFormulario($unidadeFederativa) {
    $controller = new UnidadeFederativaController();
    $conteudo = '<form class="ui form" action="unidadeFederativaView.php" method="POST">
    <fieldset class="ui form segment">
        <legend>Informações Gerais</legend>
        
         <div>
            <label>Unidade Federativa</label>
            <div class="ui left labeled icon input field">
                <input type="text" name="' . Colunas::UNIDADE_FEDERATIVA_NOME . '"
                    value="' . $unidadeFederativa->nome. '">
                <i class="map icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label>Sigla</label>
            <div class="ui left labeled icon input field">
                <input type="text" name="' . Colunas::UNIDADE_FEDERATIVA_SIGLA . '"
                    value="' . $unidadeFederativa->sigla. '" maxlength="2">
                <i class="map icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div class="ui segment">
            <i class="map icon"></i>
            <label>Regiao</label>
            <select name="' . Colunas::UNIDADE_FEDERATIVA_FK_REGIAO. '" size="1">';
    $array = $controller->listar(Colunas::REGIAO);
    foreach ($array as $linha) {
        if ($linha[Colunas::REGIAO_NOME] != 'REGIAO_ANONIMA') {
            $conteudo .= '<option value="' . $linha[Colunas::REGIAO_ID] . '"';
            if ($linha[Colunas::REGIAO_ID] === $unidadeFederativa->regiao->id) {
                $conteudo .= ' selected';
            }
            $conteudo .= '>' . $linha[Colunas::REGIAO_NOME] . '</option>';
        }
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
            <input type="text" name="' . Colunas::UNIDADE_FEDERATIVA_ID . '" value="' . $unidadeFederativa->id . '">
        </div>
    </fieldset>
</form>
<script>
$(\'.ui.form\').form(
    {
        unidadeFederativa: {
            identifier: "' . Colunas::UNIDADE_FEDERATIVA_NOME . '",
            rules: [
                emptyRule
          ]
        },
        sigla: {
            identifier: "' . Colunas::UNIDADE_FEDERATIVA_SIGLA . '",
            rules: [
                twoCharacterRule
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