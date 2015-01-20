<?php

require_once 'usuarioModel.php';

class Compra {

    public $id;
    public $data;
    public $total;
    public $usuario;
    public $concluida;
    public $formaPagamento;
    public $frete;

    public function __construct($id, $data, $total, Usuario $usuario, $concluida, $formaPagamento, $frete) {
        $this->id = $id;
        $this->data = $data;
        $this->total = $total;
        $this->usuario = $usuario;
        $this->concluida = $concluida;
        $this->formaPagamento = $formaPagamento;
        $this->frete = $frete;
    }
    
    static public function getNullObject() {
        return new Compra(
            NULL, NULL,
            NULL, Usuario::getNullObject(),
            NULL, NULL,
            NULL
        );
    }

}
