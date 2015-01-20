<?php

require_once 'compraModel.php';
require_once 'produtoModel.php';

class ItemDeProduto {

    public $id;
    public $quantidade;
    public $preco;
    public $compra;
    public $produto;

    public function __construct($id, $quantidade, $preco, Compra $compra, Produto $produto) {
        $this->id = $id;
        $this->quantidade = $quantidade;
        $this->preco = $preco;
        $this->compra = $compra;
        $this->produto = $produto;
    }
    
    static public function getNullObject() {
        return new ItemDeProduto(
            NULL, NULL,
            NULL, Compra::getNullObject(),
            Produto::getNullObject()
        );
    }

}
