<?php

require_once DIR_ROOT . 'entity/itemDeProdutoModel.php';
require_once DIR_ROOT . 'controller/compraController.php';
require_once DIR_ROOT . 'controller/produtoController.php';
require_once 'baseController.php';

class ItemDeProdutoController extends BaseController {
    
    private $compraController;
    private $produtoController;
    
    public function __construct() {
        parent::__construct();
        $this->compraController = new CompraController();
        $this->produtoController = new ProdutoController();
    }
        
    protected function inserir($itemDeProduto) {
        $sqlQuery = $this->conexao->prepare(
            'INSERT INTO ' . Colunas::ITEM_DE_PRODUTO . ' (' . Colunas::ITEM_DE_PRODUTO_QUANTIDADE
            . ', ' . Colunas::ITEM_DE_PRODUTO_PRECO . ', ' . Colunas::ITEM_DE_PRODUTO_FK_COMPRA
            . ', ' . Colunas::ITEM_DE_PRODUTO_FK_PRODUTO . ') VALUES (?, ?, ?, ?)'
        );
        
        return $sqlQuery->execute(
            array(
                $itemDeProduto->quantidade, $itemDeProduto->preco,
                $itemDeProduto->compra->id, $itemDeProduto->produto->id
            )
        );
    }
    
    protected function alterar($itemDeProduto) {
        $sqlQuery = $this->conexao->prepare(
            'UPDATE ' . Colunas::ITEM_DE_PRODUTO . ' SET ' . Colunas::ITEM_DE_PRODUTO_QUANTIDADE
            . ' = ?, ' . Colunas::ITEM_DE_PRODUTO_PRECO . ' = ?, ' . Colunas::ITEM_DE_PRODUTO_FK_COMPRA
            . ' = ?, ' . Colunas::ITEM_DE_PRODUTO_FK_PRODUTO
            . ' = ? WHERE ' . Colunas::ITEM_DE_PRODUTO_ID . ' = ?'
        );
        
        return $sqlQuery->execute(
            array(
                $itemDeProduto->quantidade, $itemDeProduto->preco,
                $itemDeProduto->compra->id, $itemDeProduto->produto->id,
                $itemDeProduto->id
            )
        );
    }
    
    public function getById($id) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT * FROM ' . Colunas::ITEM_DE_PRODUTO . ' WHERE ' . Colunas::ITEM_DE_PRODUTO_ID . ' = ?'
        );
        
        $sqlQuery->execute(
            array($id)
        );
        
        if ($sqlQuery->rowCount() > 0) {
            return $sqlQuery->fetch(PDO::FETCH_ASSOC);
        }
        else {
            return array();
        }
    }
    
    public function getId($itemDeProduto) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT ' . Colunas::ITEM_DE_PRODUTO_ID . ' FROM ' . Colunas::ITEM_DE_PRODUTO
            . ' WHERE ' . Colunas::ITEM_DE_PRODUTO_QUANTIDADE . ' = ? AND '
            . Colunas::ITEM_DE_PRODUTO_PRECO . ' = ? AND ' . Colunas::ITEM_DE_PRODUTO_FK_COMPRA
            . ' = ? AND ' . Colunas::ITEM_DE_PRODUTO_FK_PRODUTO . ' = ?'
        );
        
        $sqlQuery->execute(
            array(
                $itemDeProduto->quantidade, $itemDeProduto->preco,
                $itemDeProduto->compra->id, $itemDeProduto->produto->id
            )
        );
        
        if ($sqlQuery->rowCount() > 0) {
            return $sqlQuery->fetch(PDO::FETCH_ASSOC);
        }
        else {
            return array();
        }
    }
    
    public function construirObjeto(array $codigosIdentificadores = NULL) {
        $compra = $this->compraController->construirObjetoPorId(
            $codigosIdentificadores[Colunas::ITEM_DE_PRODUTO_FK_COMPRA]
        );
        $produto = $this->produtoController->construirObjetoPorId(
            $codigosIdentificadores[Colunas::ITEM_DE_PRODUTO_FK_PRODUTO]
        );
        $itemDeProduto = new ItemDeProduto(
            $codigosIdentificadores[Colunas::ITEM_DE_PRODUTO_ID],
            $codigosIdentificadores[Colunas::ITEM_DE_PRODUTO_QUANTIDADE],
            $codigosIdentificadores[Colunas::ITEM_DE_PRODUTO_PRECO],
            $compra, $produto
        );

        return $itemDeProduto;
    }
    
    public function construirObjetoPorId($id) {
        $arrayItemDeProduto = $this->getById($id);
        $compra = $this->compraController->construirObjetoPorId(
            $arrayItemDeProduto[Colunas::ITEM_DE_PRODUTO_FK_COMPRA]
        );
        $produto = $this->produtoController->construirObjetoPorId(
            $arrayItemDeProduto[Colunas::ITEM_DE_PRODUTO_FK_PRODUTO]
        );
        $itemDeProduto = new ItemDeProduto(
            $arrayItemDeProduto[Colunas::ITEM_DE_PRODUTO_ID],
            $arrayItemDeProduto[Colunas::ITEM_DE_PRODUTO_QUANTIDADE],
            $arrayItemDeProduto[Colunas::ITEM_DE_PRODUTO_PRECO],
            $compra, $produto
        );

        return $itemDeProduto;
    }
    
    public function getBuyName($linha) {
        $arrayCompra = $this->compraController->getById(
            $linha[Colunas::ITEM_DE_PRODUTO_FK_COMPRA]
        );
        $nomeCompra = $arrayCompra[Colunas::COMPRA_DATA] . ' '
            . $arrayCompra[Colunas::COMPRA_TOTAL];
        
        return $nomeCompra;
    }
    
    public function getProductName($linha) {
        $nomeProduto = $this->produtoController->getById(
            $linha[Colunas::ITEM_DE_PRODUTO_FK_PRODUTO]
        )[Colunas::PRODUTO_NOME];
        
        return $nomeProduto;            
    }

}
