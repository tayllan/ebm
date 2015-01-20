<?php

require_once DIR_ROOT . 'entity/cidadeModel.php';
require_once DIR_ROOT . 'controller/unidadeFederativaController.php';
require_once 'baseController.php';

class CidadeController extends BaseController {
    
    private $unidadeFederativaController;
    
    public function __construct() {
        parent::__construct();
        $this->unidadeFederativaController = new UnidadeFederativaController();
    }

    protected function inserir($cidade) {
        $sqlQuery = $this->conexao->prepare(
            'INSERT INTO ' . Colunas::CIDADE . ' (' . Colunas::CIDADE_FK_UNIDADE_FEDERATIVA
            . ', ' . Colunas::CIDADE_NOME . ') VALUES (?, ?)'
        );

        return $sqlQuery->execute(
            array(
                $cidade->unidadeFederativa->id, $cidade->nome
            )
        );
    }

    protected function alterar($cidade) {
        $sqlQuery = $this->conexao->prepare(
            'UPDATE ' . Colunas::CIDADE . ' SET ' . Colunas::CIDADE_FK_UNIDADE_FEDERATIVA . ' = ?, '
            . Colunas::CIDADE_NOME . ' = ? WHERE ' . Colunas::CIDADE_ID . ' = ?'
        );

        return $sqlQuery->execute(
                array(
                    $cidade->unidadeFederativa->id,
                    $cidade->nome, $cidade->id
                )
        );
    }

    public function getById($id) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT * FROM ' . Colunas::CIDADE . ' WHERE ' . Colunas::CIDADE_ID . ' = ?'
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

    public function getId($cidade) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT ' . Colunas::CIDADE_ID . ' FROM ' . Colunas::CIDADE . ' WHERE '
            . Colunas::CIDADE_FK_UNIDADE_FEDERATIVA . ' = ? AND ' . Colunas::CIDADE_NOME . ' LIKE ?'
        );

        $sqlQuery->execute(
            array(
                $cidade->unidadeFederativa->id, $cidade->nome
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
        $unidadeFederativa = $this->unidadeFederativaController->construirObjetoPorId(
            $codigosIdentificadores[Colunas::CIDADE_FK_UNIDADE_FEDERATIVA]
        );
        $cidade = new Cidade(
            $codigosIdentificadores[Colunas::CIDADE_ID],
            $codigosIdentificadores[Colunas::CIDADE_NOME],
            $unidadeFederativa
        );

        return $cidade;
    }

    public function construirObjetoPorId($id) {
        $arrayCidade = $this->getById($id);
        $unidadeFederativa = $this->unidadeFederativaController->construirObjetoPorId(
            $arrayCidade[Colunas::CIDADE_FK_UNIDADE_FEDERATIVA]
        );
        $cidade = new Cidade(
            $arrayCidade[Colunas::CIDADE_ID],
            $arrayCidade[Colunas::CIDADE_NOME],
            $unidadeFederativa
        );

        return $cidade;
    }
    
    public function getStateName($linha) {
        $nomeUnidadeFederativa = $this->unidadeFederativaController->getById(
            $linha[Colunas::CIDADE_FK_UNIDADE_FEDERATIVA]
        )[Colunas::UNIDADE_FEDERATIVA_NOME];
        
        return $nomeUnidadeFederativa;
    }

}
