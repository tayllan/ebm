<?php

require_once 'regiaoModel.php';

class UnidadeFederativa {

    public $id;
    public $nome;
    public $sigla;
    public $regiao;

    public function __construct($id, $nome, $sigla, Regiao $regiao) {
        $this->id = $id;
        $this->nome = $nome;
        $this->sigla = $sigla;
        $this->regiao = $regiao;
    }
    
    static public function getNullObject() {
        return new UnidadeFederativa(
            NULL, NULL,
            NULL, Regiao::getNullObject()
        );
    }

}
