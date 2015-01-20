<?php

require_once DIR_ROOT . 'controller/database.php';

class PaginaInicialController extends DAO {

    public function listar() {
        $sqlQuery = $this->conexao->query($this->getSQLSelect());
        
        if ($sqlQuery->rowCount() > 0) {
            return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
        }
        else {
            return array();
        }
    }
    
    private function getSQLSelect() {
        $sqlQuery = 'SELECT * FROM ' . Colunas::PRODUTO . ' WHERE '
            . Colunas::PRODUTO_QUANTIDADE . ' > 0';

        return $sqlQuery;
    }
    
    public function getMarcaDeProdutoById($marcaId) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT * FROM ' . Colunas::MARCA_DE_PRODUTO
            . ' WHERE ' . Colunas::MARCA_DE_PRODUTO_ID . ' = ?'
        );
        
        $sqlQuery->execute(
            array($marcaId)
        );
        
        if ($sqlQuery->rowCount() > 0) {
            return $sqlQuery->fetch(PDO::FETCH_ASSOC);
        }
        else {
            return array();
        }
    }
    
    public function getBrandName($linha) {
        $nomeMarca = $this->getMarcaDeProdutoById(
            $linha[Colunas::PRODUTO_FK_MARCA]
        )[Colunas::MARCA_DE_PRODUTO_NOME];

        return $nomeMarca;
    }
    
    public function getCategoriaDeProdutoById($categoriaId) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT * FROM ' . Colunas::CATEGORIA_DE_PRODUTO
            . ' WHERE '. Colunas::CATEGORIA_DE_PRODUTO_ID . ' = ?'
        );
        
        $sqlQuery->execute(
            array($categoriaId)
        );
        
        if ($sqlQuery->rowCount() > 0) {
            return $sqlQuery->fetch(PDO::FETCH_ASSOC);
        }
        else {
            return array();
        }
    }

    public function getCategoryName($linha) {
        $nomeCategoria = $this->getCategoriaDeProdutoById(
            $linha[Colunas::PRODUTO_FK_CATEGORIA]
        )[Colunas::CATEGORIA_DE_PRODUTO_NOME];

        return $nomeCategoria;
    }

}
