<?php

require_once '../config.php';
require_once DIR_ROOT . 'view/template/html.php';

cabecalhoHTML('Página do Administrador');
cabecalho('Super Cabeçalho');

if (isset($_SESSION[SESSAO_USUARIO_PERMISSAO])) {
    echo <<<MENU
    <div class="ui center aligned relaxed divided list segment">
        <div class="item">
            <div class="content">
                <label class="ui header top attached label">CRUDs</label>
            </div>
        </div>
    
        <div class="item">
            <i class="settings icon"></i>
            <div class="content">
                <a href="/view/regiaoView.php">Regiões</a>
            </div>
        </div>
        
        <div class="item">
            <i class="settings icon"></i>
            <div class="content">
                <a href="/view/unidadeFederativaView.php">Unidades Federativas</a>
            </div>
        </div>
        
        <div class="item">
            <i class="settings icon"></i>
            <div class="content">
                <a href="/view/cidadeView.php">Cidades</a>
            </div>
        </div>
    
        <div class="item">
            <i class="settings icon"></i>
            <div class="content">
                <a href="/view/enderecoView.php">Endereços</a>
            </div>
        </div>
    
        <div class="item">
            <i class="settings icon"></i>
            <div class="content">
                <a href="/view/usuarioView.php">Usuários</a>
            </div>
        </div>
    
        <div class="item">
            <i class="settings icon"></i>
            <div class="content">
                <a href="/view/categoriaDeProdutoView.php">Categorias de Produtos</a>
            </div>
        </div>
    
        <div class="item">
            <i class="settings icon"></i>
            <div class="content">
                <a href="/view/marcaDeProdutoView.php">Marcas de Produtos</a>
            </div>
        </div>
    
        <div class="item">
            <i class="settings icon"></i>
            <div class="content">
                <a href="/view/produtoView.php">Produtos</a>
            </div>
        </div>
    
        <div class="item">
            <i class="settings icon"></i>
            <div class="content">
                <a href="/view/compraView.php">Compras</a>
            </div>
        </div>
    
        <div class="item">
            <i class="settings icon"></i>
            <div class="content">
                <a href="/view/itemDeProdutoView.php">Itens de Produtos</a>
            </div>
        </div>
    
        <div class="item">
            <i class="settings icon"></i>
            <div class="content">
                <a href="/view/generoSexualView.php">Gêneros Sexuais</a>
            </div>
        </div>
    </div>
MENU;
}
else {
    header('Location: ../index.php');
}
rodape('Super Rodapé');
rodapeHTML();