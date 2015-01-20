<?php

require_once DIR_ROOT . 'entity/regiaoModel.php';
require_once 'baseController.php';

class RegiaoController extends BaseController {

    protected function inserir($regiao) {
        $sqlQuery = $this->conexao->prepare(
            'INSERT INTO ' . Colunas::REGIAO . ' (' . Colunas::REGIAO_NOME . ') VALUES (?)'
        );
        
        return $sqlQuery->execute(
            array(
                $regiao->nome
            )
        );
    }

    protected function alterar($regiao) {
        $sqlQuery = $this->conexao->prepare(
            'UPDATE ' . Colunas::REGIAO . ' SET ' . Colunas::REGIAO_NOME . ' = ? WHERE ' . Colunas::REGIAO_ID . ' = ?'
        );
        
        return $sqlQuery->execute(
            array(
                $regiao->nome, $regiao->id
            )
        );
    }

    public function getById($id) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT * FROM ' . Colunas::REGIAO . ' WHERE ' . Colunas::REGIAO_ID . ' = ?'
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
    
    public function getId($regiao) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT ' . Colunas::REGIAO_ID . ' FROM ' . Colunas::REGIAO . ' WHERE '
            . Colunas::REGIAO_NOME . ' LIKE ?'
        );
        
        $sqlQuery->execute(
            array(
                $regiao->nome
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
        $regiao = new Regiao(
            $codigosIdentificadores[Colunas::REGIAO_ID],
            $codigosIdentificadores[Colunas::REGIAO_NOME]
        );
        
        return $regiao;
    }
    
    public function construirObjetoPorId($id) {
        $arrayRegiao = $this->getById($id);
        $regiao = new Regiao(
            $arrayRegiao[Colunas::REGIAO_ID],
            $arrayRegiao[Colunas::REGIAO_NOME]
        );
        
        return $regiao;
    }

}
