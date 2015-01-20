<?php

function construirFormulario($endereco) {
    $controller = new CidadeController();
    $conteudo = '<form class="ui form" action="enderecoView.php" method="POST">
    <fieldset class="ui form segment">
        <legend>Informações Gerais</legend>
        
        <div>
            <label>Bairro</label>
            <div class="ui left labeled icon input field">
                <input type="text" name="' . Colunas::ENDERECO_BAIRRO . '" value="' . $endereco->bairro . '">
                <i class="map icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label>CEP</label>
            <div class="ui left labeled icon input field">
                <input type="text" name="' . Colunas::ENDERECO_CEP
                    . '" value="' . $endereco->cep . '" maxlength="8">
                <i class="map icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label>Logradouro</label>
            <div class="ui left labeled icon input field">
                <input type="text" name="' . Colunas::ENDERECO_LOGRADOURO . '" value="' . $endereco->logradouro . '">
                <i class="map icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label>Número</label>
            <div class="ui left labeled icon input field">
                <input type="number" name="' . Colunas::ENDERECO_NUMERO . '" value="' . $endereco->numero . '">
                <i class="map icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label>Cidade</label>
            <div class="ui left labeled icon input field">
                <input type="text" name="' . Colunas::CIDADE_NOME
                    . '" value="' . $endereco->cidade->nome . '">
                <i class="map icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div class="ui segment">
            <i class="map icon"></i>
            <label>Unidade Federativa</label>
            <select name="' . Colunas::CIDADE_FK_UNIDADE_FEDERATIVA. '" size="1">';
    $array = $controller->listar(Colunas::UNIDADE_FEDERATIVA);
    foreach ($array as $linha) {
        if ($linha[Colunas::UNIDADE_FEDERATIVA_NOME] != 'UNIDADE_FEDERATIVA_ANONIMA') {
            $conteudo .= '<option value="' . $linha[Colunas::UNIDADE_FEDERATIVA_ID] . '"';
            if ($linha[Colunas::UNIDADE_FEDERATIVA_ID] === $endereco->cidade->unidadeFederativa->id) {
                $conteudo .= ' selected';
            }
            $conteudo .= '>' . $linha[Colunas::UNIDADE_FEDERATIVA_NOME] . '</option>';
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
            <input type="hidden" name="' . Colunas::ENDERECO_ID . '" value="' . $endereco->id . '">
        </div>
    </fieldset>
</form>
<script>
$(\'.ui.form\').form(
    {
        bairro: {
            identifier: "' . Colunas::ENDERECO_BAIRRO . '",
            rules: [
                emptyRule
          ]
        },
        cep: {
            identifier: "' . Colunas::ENDERECO_CEP . '",
            rules: [
                eightCharacterRule
          ]
        },
        rua: {
            identifier: "' . Colunas::ENDERECO_LOGRADOURO . '",
            rules: [
                emptyRule
          ]
        },
        numero: {
            identifier: "' . Colunas::ENDERECO_NUMERO . '",
            rules: [
                emptyRule
          ]
        },
        cidade: {
            identifier: "' . Colunas::CIDADE_NOME . '",
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