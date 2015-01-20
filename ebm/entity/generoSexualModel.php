<?php

class GeneroSexual {

    public $id;
    public $nome;

    public function __construct($id, $nome) {
        $this->id = $id;
        $this->nome = $nome;
    }
    
    static public function getNullObject() {
        return new GeneroSexual(
            NULL, NULL
        );
    }

}
