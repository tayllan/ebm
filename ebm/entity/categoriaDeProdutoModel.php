<?php

class CategoriaDeProduto {

    public $id;
    public $nome;

    public function __construct($id, $nome) {
        $this->id = $id;
        $this->nome = $nome;
    }
    
    static public function getNullObject() {
        return new CategoriaDeProduto(
            NULL, NULL
        );
    }

}
