<?php

require_once DIR_ROOT . 'entity/categoriaDeProdutoModel.php';
require_once 'baseController.php';

class CategoriaDeProdutoController extends BaseController {

    protected function inserir($categoriaDeProduto) {
        $sqlQuery = $this->conexao->prepare(
            'INSERT INTO ' . Colunas::CATEGORIA_DE_PRODUTO . ' ('
            . Colunas::CATEGORIA_DE_PRODUTO_NOME . ') VALUES (?)'
        );
        
        return $sqlQuery->execute(
            array($categoriaDeProduto->nome)
        );
    }

    protected function alterar($categoriaDeProduto) {
        $sqlQuery = $this->conexao->prepare(
            'UPDATE ' . Colunas::CATEGORIA_DE_PRODUTO . ' SET ' . Colunas::CATEGORIA_DE_PRODUTO_NOME
            . ' = ? WHERE ' . Colunas::CATEGORIA_DE_PRODUTO_ID . ' = ?'
        );
        
        return $sqlQuery->execute(
            array(
                $categoriaDeProduto->nome, $categoriaDeProduto->id
            )
        );
    }

    public function getById($id) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT * FROM ' . Colunas::CATEGORIA_DE_PRODUTO
            . ' WHERE '. Colunas::CATEGORIA_DE_PRODUTO_ID . ' = ?'
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
    
    public function construirObjeto(array $codigosIdentificadores = NULL) {
        $categoriaDeProduto = new CategoriaDeProduto(
            $codigosIdentificadores[Colunas::CATEGORIA_DE_PRODUTO_ID],
            $codigosIdentificadores[Colunas::CATEGORIA_DE_PRODUTO_NOME]
        );

        return $categoriaDeProduto;
    }
    
    public function construirObjetoPorId($id) {
        $arrayCategoria = $this->getById($id);
        $categoriaDeProduto = new CategoriaDeProduto(
            $arrayCategoria[Colunas::CATEGORIA_DE_PRODUTO_ID],
            $arrayCategoria[Colunas::CATEGORIA_DE_PRODUTO_NOME]
        );
        
        return $categoriaDeProduto;
    }

}
