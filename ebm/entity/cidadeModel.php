<?php

require_once 'unidadeFederativaModel.php';

class Cidade {

    public $id;
    public $nome;
    public $unidadeFederativa;

    public function __construct($id, $nome, UnidadeFederativa $unidadeFederativa) {
        $this->id = $id;
        $this->nome = $nome;
        $this->unidadeFederativa = $unidadeFederativa;
    }
    
    static public function getNullObject() {
        return new Cidade(
            NULL, NULL,
            UnidadeFederativa::getNullObject()
        );
    }

}
