<?php

require_once 'cidadeModel.php';

class Endereco {

    public $id;
    public $bairro;
    public $cep;
    public $logradouro;
    public $numero;
    public $cidade;

    public function __construct($id, $bairro, $cep, $logradouro, $numero, Cidade $cidade) {
        $this->id = $id;
        $this->bairro = $bairro;
        $this->cep = $cep;
        $this->logradouro = $logradouro;
        $this->numero = $numero;
        $this->cidade = $cidade;
    }
    
    static public function getNullObject() {
        return new Endereco(
            NULL, NULL,
            NULL, NULL,
            NULL, Cidade::getNullObject()
        );
    }

}
