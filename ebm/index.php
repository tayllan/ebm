<?php

require_once 'config.php';
require_once DIR_ROOT . 'view/template/html.php';
require_once DIR_ROOT . 'view/paginaInicialView.php';

cabecalhoHTML('HOME');
cabecalho('Super Cabeçalho');

$listagemDeProdutos = new PaginaInicialView();
$listagemDeProdutos->listar();

rodape('Super Rodapé');
rodapeHTML();
