<?php

require_once 'enderecoModel.php';
require_once 'generoSexualModel.php';

class Usuario {

    public $id;
    public $nome;
    public $login;
    public $senha;
    public $cpf;
    public $telefone;
    public $dataDeNascimento;
    public $administrador;
    public $endereco;
    public $generoSexual;
    public $ativo;

    public function __construct($id, $nome, $login, $senha, $cpf, $telefone, $dataDeNascimento,
        $administrador, Endereco $endereco, GeneroSexual $generoSexual, $ativo = TRUE) {
        
        $this->id = $id;
        $this->nome = $nome;
        $this->login = $login;
        $this->senha = $senha;
        $this->cpf = $cpf;
        $this->telefone = $telefone;
        $this->dataDeNascimento = $dataDeNascimento;
        $this->administrador = $administrador;
        $this->endereco = $endereco;
        $this->generoSexual = $generoSexual;
        $this->ativo = $ativo;
    }
    
    static public function getNullObject() {
        return new Usuario(
            NULL, NULL,
            NULL, NULL,
            NULL, NULL,
            NULL, NULL,
            Endereco::getNullObject(), GeneroSexual::getNullObject(),
            NULL
        );
    }

}
