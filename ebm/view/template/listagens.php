<?php

function criarTabela($caption, $nomeView, array $array) {
    $conteudo = '<form class="ui form" action="' . $nomeView . '.php" method="POST">
        
    <button type="submit" name="editar" value="false" class="ui green submit button small">
        <i class="add icon"></i>Cadastrar
    </button>

    <br>
    <br>

    <table id="tabela-paginada" class="ui table small">
        <caption class="ui header">' . $caption . '</caption>

        <thead>
            <tr>
                <th>Alterar</th>';
    
    foreach ($array as $elemento) {
        $conteudo .= '<th>' . $elemento . '</th>';
    }
    
    return $conteudo . '<th>Deletar</th></tr></thead><tbody>';
}