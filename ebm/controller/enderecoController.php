<?php

require_once DIR_ROOT . 'entity/enderecoModel.php';
require_once DIR_ROOT . 'controller/cidadeController.php';
require_once 'baseController.php';

class EnderecoController extends BaseController {
    
    private $cidadeController;
    
    public function __construct() {
        parent::__construct();
        $this->cidadeController = new CidadeController();
    }

    protected function inserir($endereco) {
        $sqlQuery = $this->conexao->prepare(
            'INSERT INTO ' . Colunas::ENDERECO . ' (' . Colunas::ENDERECO_BAIRRO
            . ', ' . Colunas::ENDERECO_CEP
            . ', ' . Colunas::ENDERECO_LOGRADOURO . ', ' . Colunas::ENDERECO_NUMERO
            . ', ' . Colunas::ENDERECO_FK_CIDADE . ') VALUES (?, ?, ?, ?, ?)'
        );
        
        $array = $this->getId($endereco);
        
        if (empty($array)) {
            return $sqlQuery->execute(
                    array(
                        $endereco->bairro, $endereco->cep,
                        $endereco->logradouro, $endereco->numero,
                        $endereco->cidade->id
                    )
            );
        }
        else {
            return false;
        }
    }

    protected function alterar($endereco) {
        $sqlQuery = $this->conexao->prepare(
            'UPDATE ' . Colunas::ENDERECO . ' SET ' . Colunas::ENDERECO_BAIRRO 
            . ' = ?, ' . Colunas::ENDERECO_CEP
            . ' = ?, ' . Colunas::ENDERECO_LOGRADOURO . ' = ?, ' . Colunas::ENDERECO_NUMERO
            . ' = ?, ' . Colunas::ENDERECO_FK_CIDADE . ' = ? WHERE ' . Colunas::ENDERECO_ID . ' = ?'
        );

        return $sqlQuery->execute(
                array(
                    $endereco->bairro, $endereco->cep,
                    $endereco->logradouro, $endereco->numero,
                    $endereco->cidade->id, $endereco->id
                )
        );
    }

    public function getById($id) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT * FROM ' . Colunas::ENDERECO . ' WHERE ' . Colunas::ENDERECO_ID . ' = ?'
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

    public function getId($endereco) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT ' . Colunas::ENDERECO_ID . ' FROM ' . Colunas::ENDERECO
            . ' WHERE ' . Colunas::ENDERECO_BAIRRO
            . ' LIKE ? AND ' . Colunas::ENDERECO_CEP . ' LIKE ? AND ' . Colunas::ENDERECO_LOGRADOURO
            . ' LIKE ? AND ' . Colunas::ENDERECO_NUMERO . ' LIKE ? AND ' . Colunas::ENDERECO_FK_CIDADE . ' = ?'
        );

        $sqlQuery->execute(
                array(
                    $endereco->bairro, $endereco->cep,
                    $endereco->logradouro, $endereco->numero,
                    $endereco->cidade->id
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
        $cidade = $this->cidadeController->construirObjetoPorId(
            $codigosIdentificadores[Colunas::ENDERECO_FK_CIDADE]
        );
        $endereco = new Endereco(
            $codigosIdentificadores[Colunas::ENDERECO_ID],
            $codigosIdentificadores[Colunas::ENDERECO_BAIRRO],
            $codigosIdentificadores[Colunas::ENDERECO_CEP],
            $codigosIdentificadores[Colunas::ENDERECO_LOGRADOURO],
            $codigosIdentificadores[Colunas::ENDERECO_NUMERO],
            $cidade
        );

        return $endereco;
    }

    public function construirObjetoPorId($id) {
        $arrayEndereco = $this->getById($id);
        $cidade = $this->cidadeController->construirObjetoPorId(
            $arrayEndereco[Colunas::ENDERECO_FK_CIDADE]
        );
        $endereco = new Endereco(
            $arrayEndereco[Colunas::ENDERECO_ID],
            $arrayEndereco[Colunas::ENDERECO_BAIRRO],
            $arrayEndereco[Colunas::ENDERECO_CEP],
            $arrayEndereco[Colunas::ENDERECO_LOGRADOURO],
            $arrayEndereco[Colunas::ENDERECO_NUMERO],
            $cidade
        );

        return $endereco;
    }
    
    public function getCityName($linha) {
        $nomeCidade = $this->cidadeController->getById(
            $linha[Colunas::ENDERECO_FK_CIDADE]
        )[Colunas::CIDADE_NOME];
        
        return $nomeCidade;
    }
    
    public function getCidadeId($cidadeNome, $cidadeFkUnidadeFederativa) {
        $cidade = $this->cidadeController->construirObjeto(
            array (
                Colunas::CIDADE_FK_UNIDADE_FEDERATIVA => $cidadeFkUnidadeFederativa,
                Colunas::CIDADE_NOME => $cidadeNome,
                Colunas::CIDADE_ID => NULL
            )
        );
        $this->cidadeController->rotearInsercao($cidade);
        $array = $this->cidadeController->getId($cidade);
        
        return $array[Colunas::CIDADE_ID];
    }

}
