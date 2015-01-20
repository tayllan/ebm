<?php

require_once DIR_ROOT . 'entity/generoSexualModel.php';
require_once 'baseController.php';

class GeneroSexualController extends BaseController {

    protected function inserir($generoSexual) {
        $sqlQuery = $this->conexao->prepare(
            'INSERT INTO ' . Colunas::GENERO_SEXUAL . ' (' . Colunas::GENERO_SEXUAL_NOME . ') VALUES (?)'
        );
        
        return $sqlQuery->execute(
            array($generoSexual->nome)
        );
    }

    protected function alterar($generoSexual) {
        $sqlQuery = $this->conexao->prepare(
            'UPDATE ' . Colunas::GENERO_SEXUAL . ' SET ' . Colunas::GENERO_SEXUAL_NOME
            . ' = ? WHERE ' . Colunas::GENERO_SEXUAL_ID . ' = ?'
        );
        
        return $sqlQuery->execute(
            array(
                $generoSexual->nome, $generoSexual->id
            )
        );
    }

    public function getById($id) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT * FROM ' . Colunas::GENERO_SEXUAL . ' WHERE ' . Colunas::GENERO_SEXUAL_ID . ' = ?'
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
    
    public function getId($generoSexual) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT ' . Colunas::GENERO_SEXUAL_ID . ' FROM ' . Colunas::GENERO_SEXUAL
            . ' WHERE ' . Colunas::GENERO_SEXUAL_NOME . ' LIKE ?'
        );
        
        $sqlQuery->execute(
            array($generoSexual->nome)
        );
        
        if ($sqlQuery->rowCount() > 0) {
            return $sqlQuery->fetch(PDO::FETCH_ASSOC);
        }
        else {
            return array();
        }
    }
    
    public function construirObjeto(array $codigosIdentificadores = NULL) {
        $generoSexual = new GeneroSexual(
            $codigosIdentificadores[Colunas::GENERO_SEXUAL_ID],
            $codigosIdentificadores[Colunas::GENERO_SEXUAL_NOME]
        );

        return $generoSexual;
    }
    
    public function construirObjetoPorId($id) {
        $arrayGenero = $this->getById($id);
        $generoSexual = new GeneroSexual(
            $arrayGenero[Colunas::GENERO_SEXUAL_ID],
            $arrayGenero[Colunas::GENERO_SEXUAL_NOME]
        );
        
        return $generoSexual;
    }

}
