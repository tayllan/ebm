<?php

require_once DIR_ROOT . 'entity/marcaDeProdutoModel.php';
require_once 'baseController.php';

class MarcaDeProdutoController extends BaseController {

    protected function inserir($marcaDeProduto) {
        $sqlQuery = $this->conexao->prepare(
            'INSERT INTO ' . Colunas::MARCA_DE_PRODUTO . ' (' . Colunas::MARCA_DE_PRODUTO_NOME . ') VALUES (?)'
        );
        
        return $sqlQuery->execute(
            array($marcaDeProduto->nome)
        );
    }

    protected function alterar($marcaDeProduto) {
        $sqlQuery = $this->conexao->prepare(
            'UPDATE ' . Colunas::MARCA_DE_PRODUTO . ' SET ' . Colunas::MARCA_DE_PRODUTO_NOME
            . '=? WHERE ' . Colunas::MARCA_DE_PRODUTO_ID . '=?'
        );
        
        return $sqlQuery->execute(
            array(
                $marcaDeProduto->nome,
                $marcaDeProduto->id
            )
        );
    }

    public function getById($id) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT * FROM ' . Colunas::MARCA_DE_PRODUTO . ' WHERE ' . Colunas::MARCA_DE_PRODUTO_ID . ' = ?'
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
        $marcaDeProduto = new MarcaDeProduto(
            $codigosIdentificadores[Colunas::MARCA_DE_PRODUTO_ID],
            $codigosIdentificadores[Colunas::MARCA_DE_PRODUTO_NOME]
        );

        return $marcaDeProduto;
    }
    
    public function construirObjetoPorId($id) {
        $arrayMarca = $this->getById($id);
        $marcaDeProduto = new MarcaDeProduto(
            $arrayMarca[Colunas::MARCA_DE_PRODUTO_ID],
            $arrayMarca[Colunas::MARCA_DE_PRODUTO_NOME]
        );
        
        return $marcaDeProduto;
    }

}
