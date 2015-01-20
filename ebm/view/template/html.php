<?php

function cabecalhoHTML($titulo) {
    echo <<<CABECALHO_HTML
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{$titulo}</title>
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="/resource/packaged/css/semantic.min.css">
        <link rel="stylesheet" type="text/css" href="/resource/css/estilo.css">
        <link rel="stylesheet" type="text/css" href="/resource/css/jquery.dynatable.css">

        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.address/1.6/jquery.address.js"></script>
        <script src="/resource/packaged/javascript/semantic.js"></script>
        <script src="/resource/js/javascript.js"></script>
        <script src="/resource/js/jquery.dynatable.js"></script>
    </head>
    <body>
CABECALHO_HTML;
}

function cabecalho($mensagem) {
    $conteudo ='<header class="ui center aligned segment">
    <a href="/index.php"><img src="/resource/imagens/logo.png"></a>
</header>
<div class="ui center aligned segment">';
    if (isset($_SESSION[SESSAO_LOGADO])) {
        $conteudo .= '<div class="ui green label"><i class="mail icon"> ' . $_SESSION[SESSAO_USUARIO_LOGIN]
            . '</i></div>'
            . '<div class="ui label"><a href="/view/perfilView.php" class="detail">'
            . '<i class="settings icon"> Meu Perfil</i></a></div>';
        if (isset($_SESSION[SESSAO_USUARIO_PERMISSAO])) {
            $conteudo .= '<div class="ui label"><a href="/core/paginaDoAdministrador.php" class="detail">'
            . '<i class="settings icon"> Página do Administrador</i></a></div>';
        }
        $conteudo .= '<div class="ui label"><a href="/core/logout.php" class="detail">'
            . '<i class="sign out icon"> Sair</i></a></div>';
        
    }
    else {
        $conteudo .= '<div class="ui pointing dropdown link item">
            <div class="ui label">
                <i class="user icon"></i>
                RealizarLogin
            </div>
            <div class="menu">
                <a class="item" href="/core/login.php">
                    <i class="sign in icon"></i>
                    Realizar Login
                </a>
                <a class="item" href="/view/realizarCadastroView.php">
                    <i class="signup icon"></i>
                    Cadastrar-se
                </a>
                <a class="item" href="/view/reativarContaView.php">
                    <i class="help icon"></i>
                    Reativar Conta
                </a>
                <a class="item" href="/view/recuperarSenhaView.php">
                    <i class="lock icon"></i>
                    Recuperar Senha
                </a>
            </div>
        </div>
        <script>
        $(".ui.dropdown").dropdown();
        </script>';
    }
        
    echo $conteudo . '<div class="ui label"><a href="/view/carrinhoDeComprasView.php">'
        . '<i class="cart icon"> Meu Carrinho</i></a></div></div>';
}

function rodape($mensagem) {
    echo <<<RODAPE
<footer class="ui center aligned segment">
    <p class="ui black label">
        EBM e-Commerce LTDA, 02.123.123/0001-11
    </p>
    <p class="ui black label">
        UTFPR Campus Cornélio Procópio - Avenida Alberto Carazzai, 1640
    </p>
    <p class="ui black label">
        Cornélio Procópio - PR, 86300-000
    </p>
</footer>
RODAPE;
}

function rodapeHTML() {
    echo <<<RODAPE_HTML
    </body>
</html>
RODAPE_HTML;
}