<?php

require_once DIR_ROOT . 'entity/unidadeFederativaModel.php';
require_once DIR_ROOT . 'controller/regiaoController.php';
require_once 'baseController.php';

class UnidadeFederativaController extends BaseController {

    private $regiaoController;

    public function __construct() {
        parent::__construct();
        $this->regiaoController = new RegiaoController();
    }

    protected function inserir($unidadeFederativa) {
        $sqlQuery = $this->conexao->prepare(
            'INSERT INTO ' . Colunas::UNIDADE_FEDERATIVA . ' (' . Colunas::UNIDADE_FEDERATIVA_NOME
            . ', ' . Colunas::UNIDADE_FEDERATIVA_SIGLA . ', ' . Colunas::UNIDADE_FEDERATIVA_FK_REGIAO
            . ') VALUES (?, ?, ?)'
        );

        return $sqlQuery->execute(
                array(
                    $unidadeFederativa->nome, $unidadeFederativa->sigla,
                    $unidadeFederativa->regiao->id
                )
        );
    }

    protected function alterar($unidadeFederativa) {
        $sqlQuery = $this->conexao->prepare(
            'UPDATE ' . Colunas::UNIDADE_FEDERATIVA . ' SET ' . Colunas::UNIDADE_FEDERATIVA_NOME . ' = ?, '
            . Colunas::UNIDADE_FEDERATIVA_SIGLA . ' = ?, ' . Colunas::UNIDADE_FEDERATIVA_FK_REGIAO
            . ' = ? WHERE ' . Colunas::UNIDADE_FEDERATIVA_ID . ' = ?'
        );

        return $sqlQuery->execute(
                array(
                    $unidadeFederativa->nome, $unidadeFederativa->sigla,
                    $unidadeFederativa->regiao->id, $unidadeFederativa->id
                )
        );
    }

    public function getById($id) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT * FROM ' . Colunas::UNIDADE_FEDERATIVA . ' WHERE ' . Colunas::UNIDADE_FEDERATIVA_ID . ' = ?'
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
    
    public function getId($unidadeFederativa) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT ' . Colunas::UNIDADE_FEDERATIVA_ID . ' FROM ' . Colunas::UNIDADE_FEDERATIVA
            . ' WHERE ' . Colunas::UNIDADE_FEDERATIVA_NOME . ' LIKE ? AND ' . Colunas::UNIDADE_FEDERATIVA_SIGLA
            . ' LIKE ? AND ' . Colunas::UNIDADE_FEDERATIVA_FK_REGIAO . ' = ?'
        );
        
        $sqlQuery->execute(
            array(
                $unidadeFederativa->nome, $unidadeFederativa->sigla,
                $unidadeFederativa->regiao->id
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
        $regiao = $this->regiaoController->construirObjetoPorId(
            $codigosIdentificadores[Colunas::UNIDADE_FEDERATIVA_FK_REGIAO]
        );
        $unidadeFederativa = new UnidadeFederativa(
            $codigosIdentificadores[Colunas::UNIDADE_FEDERATIVA_ID],
            $codigosIdentificadores[Colunas::UNIDADE_FEDERATIVA_NOME],
            $codigosIdentificadores[Colunas::UNIDADE_FEDERATIVA_SIGLA],
            $regiao
        );

        return $unidadeFederativa;
    }

    public function construirObjetoPorId($id) {
        $arrayUnidadeFederativa = $this->getById($id);
        $regiao = $this->regiaoController->construirObjetoPorId(
            $arrayUnidadeFederativa[Colunas::UNIDADE_FEDERATIVA_FK_REGIAO]
        );
        $unidadeFederativa = new UnidadeFederativa(
            $arrayUnidadeFederativa[Colunas::UNIDADE_FEDERATIVA_ID],
            $arrayUnidadeFederativa[Colunas::UNIDADE_FEDERATIVA_NOME],
            $arrayUnidadeFederativa[Colunas::UNIDADE_FEDERATIVA_SIGLA],
            $regiao
        );

        return $unidadeFederativa;
    }
    
    public function getRegionName($linha) {
        $nomeRegiao = $this->regiaoController->getById(
            $linha[Colunas::UNIDADE_FEDERATIVA_FK_REGIAO]
        )[Colunas::REGIAO_NOME];
        
        return $nomeRegiao;
    }

}
