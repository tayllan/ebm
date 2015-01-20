<?php

class Colunas {
    const UNIDADE_FEDERATIVA = 'unidadeFederativa';
    const UNIDADE_FEDERATIVA_ID = 'unidade_federativa_id';
    const UNIDADE_FEDERATIVA_NOME = 'unidade_federativa_nome';
    const UNIDADE_FEDERATIVA_SIGLA = 'unidade_federativa_sigla';
    const UNIDADE_FEDERATIVA_FK_REGIAO = 'unidade_federativa_fk_id_regiao';
    
    const REGIAO = 'regiao';
    const REGIAO_ID = 'regiao_id';
    const REGIAO_NOME = 'regiao_nome';
    
    const USUARIO = 'usuario';
    const USUARIO_ID ='usuario_id';
    const USUARIO_NOME = 'usuario_nome';
    const USUARIO_LOGIN = 'usuario_email';
    const USUARIO_SENHA = 'usuario_senha';
    const USUARIO_CPF = 'usuario_cpf';
    const USUARIO_TELEFONE = 'usuario_telefone';
    const USUARIO_DATA_DE_NASCIMENTO = 'usuario_data_de_nascimento';
    const USUARIO_ADMINISTRADOR = 'usuario_permissao';
    const USUARIO_FK_ENDERECO = 'usuario_fk_id_endereco';
    const USUARIO_FK_GENERO_SEXUAL = 'usuario_fk_id_genero_sexual';
    const USUARIO_ATIVO = 'usuario_ativo';
    
    const CATEGORIA_DE_PRODUTO = 'categoriaDeProduto';
    const CATEGORIA_DE_PRODUTO_ID = 'categoria_de_produto_id';
    const CATEGORIA_DE_PRODUTO_NOME = 'categoria_de_produto_nome';
    
    const MARCA_DE_PRODUTO = 'marcaDeProduto';
    const MARCA_DE_PRODUTO_ID = 'marca_de_produto_id';
    const MARCA_DE_PRODUTO_NOME = 'marca_de_produto_nome';
    
    const PRODUTO = 'produto';
    const PRODUTO_ID = 'produto_id';
    const PRODUTO_FK_MARCA = 'produto_fk_id_marca_de_produto';
    const PRODUTO_FK_CATEGORIA ='produto_fk_id_categoria_de_produto';
    const PRODUTO_NOME = 'produto_nome';
    const PRODUTO_DESCRICAO = 'produto_descricao';
    const PRODUTO_PRECO = 'produto_preco';
    const PRODUTO_QUANTIDADE = 'produto_quantidade';
    const PRODUTO_IMAGEM = 'produto_caminho_imagem';
    
    const CIDADE = 'cidade';
    const CIDADE_ID = 'cidade_id';
    const CIDADE_FK_UNIDADE_FEDERATIVA = 'cidade_fk_id_unidade_federativa';
    const CIDADE_NOME = 'cidade_nome';
    
    const ENDERECO = 'endereco';
    const ENDERECO_ID = 'endereco_id';
    const ENDERECO_BAIRRO = 'endereco_bairro';
    const ENDERECO_CEP = 'endereco_cep';
    const ENDERECO_LOGRADOURO = 'endereco_logradouro';
    const ENDERECO_NUMERO = 'endereco_numero';
    const ENDERECO_FK_CIDADE = 'endereco_fk_id_cidade';
    
    const GENERO_SEXUAL = 'generoSexual';
    const GENERO_SEXUAL_ID = 'genero_sexual_id';
    const GENERO_SEXUAL_NOME = 'genero_sexual_nome';
    
    const COMPRA = 'compra';
    const COMPRA_ID = 'compra_id';
    const COMPRA_DATA = 'compra_data';
    const COMPRA_TOTAL = 'compra_total';
    const COMPRA_FK_USUARIO = 'compra_fk_id_usuario';
    const COMPRA_CONCLUIDA = 'compra_concluida';
    const COMPRA_FORMA_PAGAMENTO = 'compra_forma_de_pagamento';
    const COMPRA_FRETE = 'compra_frete';
    
    const ITEM_DE_PRODUTO = 'itemDeProduto';
    const ITEM_DE_PRODUTO_ID = 'item_de_produto_id';
    const ITEM_DE_PRODUTO_QUANTIDADE = 'item_de_produto_quantidade';
    const ITEM_DE_PRODUTO_PRECO = 'item_de_produto_preco';
    const ITEM_DE_PRODUTO_FK_COMPRA = 'item_de_produto_fk_id_compra';
    const ITEM_DE_PRODUTO_FK_PRODUTO = 'item_de_produto_fk_id_produto';
}

\define('DIR_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/');

\define('MENSAGEM_CADASTRO_SUCESSO', ' salvo(a) com sucesso!');

\define('MENSAGEM_DELECAO_SUCESSO', ' deletado(a) com sucesso!');

\define('MENSAGEM_ERRO', '<p class="ui red label">Ocorreu algum erro!<p>');

\define('SESSAO_LOGADO', 'logado');

\define('SESSAO_USUARIO_ID', 'usuarioId');

\define('SESSAO_USUARIO_LOGIN', 'usuarioLogin');

\define('SESSAO_USUARIO_PERMISSAO', 'usuarioPermissao');

session_start();