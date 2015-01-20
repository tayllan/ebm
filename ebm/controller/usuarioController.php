<?php

require_once DIR_ROOT . 'entity/usuarioModel.php';
require_once DIR_ROOT . 'controller/enderecoController.php';
require_once DIR_ROOT . 'controller/generoSexualController.php';
require_once DIR_ROOT . 'controller/cidadeController.php';
require_once DIR_ROOT . 'controller/unidadeFederativaController.php';
require_once 'baseController.php';

class UsuarioController extends BaseController {
    
    private $enderecoController;
    private $generoSexualController;
    private $cidadeController;
    private $unidadeFederativaController;
    
    public function __construct() {
        parent::__construct();
        $this->enderecoController = new EnderecoController();
        $this->generoSexualController = new GeneroSexualController();
        $this->cidadeController = new CidadeController();
        $this->unidadeFederativaController = new UnidadeFederativaController();
    }
        
    protected function inserir($usuario) {
        $sqlQuery = $this->conexao->prepare(
            'INSERT INTO ' . Colunas::USUARIO . ' (' . Colunas::USUARIO_NOME . ', ' . Colunas::USUARIO_LOGIN
            . ', ' . Colunas::USUARIO_SENHA . ', ' . Colunas::USUARIO_CPF
            . ', ' . Colunas::USUARIO_TELEFONE . ', ' . Colunas::USUARIO_DATA_DE_NASCIMENTO
            . ', ' . Colunas::USUARIO_ADMINISTRADOR . ', ' . Colunas::USUARIO_FK_ENDERECO
            . ', ' . Colunas::USUARIO_FK_GENERO_SEXUAL . ') VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        
        return $sqlQuery->execute(
            array(
                $usuario->nome, $usuario->login,
                md5($usuario->senha), $usuario->cpf,
                $usuario->telefone, $usuario->dataDeNascimento,
                $usuario->administrador, $usuario->endereco->id,
                $usuario->generoSexual->id
            )
        );
    }
    
    protected function alterar($usuario) {
        $sqlQuery = $this->conexao->prepare(
            'UPDATE ' . Colunas::USUARIO . ' SET ' . Colunas::USUARIO_NOME . ' = ?, ' . Colunas::USUARIO_LOGIN
            . ' = ?, ' . Colunas::USUARIO_SENHA . ' = ?, ' . Colunas::USUARIO_CPF
            . ' = ?, ' . Colunas::USUARIO_TELEFONE . ' = ?, ' . Colunas::USUARIO_DATA_DE_NASCIMENTO
            . ' = ?, ' . Colunas::USUARIO_ADMINISTRADOR . ' = ?, ' . Colunas::USUARIO_FK_ENDERECO
            . ' = ?, ' . Colunas::USUARIO_FK_GENERO_SEXUAL . ' = ?, ' . Colunas::USUARIO_ATIVO
            . ' = ? WHERE ' . Colunas::USUARIO_ID . ' = ?'
        );
        if ($usuario->administrador === 'true') {
            $usuario->administrador = TRUE;
        }
        if ($usuario->ativo === 'true') {
            $usuario->ativo = TRUE;
        }
        if (strlen($usuario->senha) < 32) {
            $usuario->senha = md5($usuario->senha);
        }
        
        return $sqlQuery->execute(
            array(
                $usuario->nome, $usuario->login,
                $usuario->senha, $usuario->cpf,
                $usuario->telefone, $usuario->dataDeNascimento,
                $usuario->administrador, $usuario->endereco->id,
                $usuario->generoSexual->id, $usuario->ativo,
                $usuario->id
            )
        );         
    }
    
    public function getById($id) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT * FROM ' . Colunas::USUARIO . ' WHERE ' . Colunas::USUARIO_ID . ' = ?'
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
    
    public function getId($usuario) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT ' . Colunas::USUARIO_ID . ' FROM ' . Colunas::USUARIO . ' WHERE '
            . Colunas::USUARIO_LOGIN . ' LIKE ? AND '
            . Colunas::USUARIO_SENHA . ' LIKE ?'
        );
        
        if (strlen($usuario->senha) < 32) {
            $usuario->senha = md5($usuario->senha);
        }
        
        $sqlQuery->execute(
            array(
                $usuario->login, $usuario->senha
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
        $usuario = new Usuario(
            $codigosIdentificadores[Colunas::USUARIO_ID],
            $codigosIdentificadores[Colunas::USUARIO_NOME],
            $codigosIdentificadores[Colunas::USUARIO_LOGIN],
            $codigosIdentificadores[Colunas::USUARIO_SENHA],
            $codigosIdentificadores[Colunas::USUARIO_CPF],
            $codigosIdentificadores[Colunas::USUARIO_TELEFONE],
            $codigosIdentificadores[Colunas::USUARIO_DATA_DE_NASCIMENTO],
            $codigosIdentificadores[Colunas::USUARIO_ADMINISTRADOR],
            $this->construirObjetoEndereco(), $this->construirObjetoGeneroSexual(),
            $codigosIdentificadores[Colunas::USUARIO_ATIVO]
        );
        
        $this->rotearInsercao($usuario);
        $array = $this->getId($usuario);
        $usuario->id = $array[Colunas::USUARIO_ID];
        
        return $usuario;
    }
    
    public function construirObjetoPorId($id) {
        $arrayUsuario = $this->getById($id);
        $endereco = $this->enderecoController->construirObjetoPorId(
            $arrayUsuario[Colunas::USUARIO_FK_ENDERECO]
        );
        $generoSexual = $this->generoSexualController->construirObjetoPorId(
            $arrayUsuario[Colunas::USUARIO_FK_GENERO_SEXUAL]
        );
        $usuario = new Usuario(
            $arrayUsuario[Colunas::USUARIO_ID], $arrayUsuario[Colunas::USUARIO_NOME],
            $arrayUsuario[Colunas::USUARIO_LOGIN], $arrayUsuario[Colunas::USUARIO_SENHA],
            $arrayUsuario[Colunas::USUARIO_CPF], $arrayUsuario[Colunas::USUARIO_TELEFONE],
            $arrayUsuario[Colunas::USUARIO_DATA_DE_NASCIMENTO], $arrayUsuario[Colunas::USUARIO_ADMINISTRADOR],
            $endereco, $generoSexual,
            $arrayUsuario[Colunas::USUARIO_ATIVO]
        );
        
        return $usuario;
    }
    
    public function getAddressName($linha) {
        $arrayEndereco = $this->enderecoController->getById(
            $linha[Colunas::USUARIO_FK_ENDERECO]
        );
        $nomeEndereco = $arrayEndereco[Colunas::ENDERECO_LOGRADOURO] . ', '
            . $arrayEndereco[Colunas::ENDERECO_NUMERO] . ' ('
            . $arrayEndereco[Colunas::ENDERECO_BAIRRO] . ' - '
            . $arrayEndereco[Colunas::ENDERECO_CEP] . ')';
        
        return $nomeEndereco;
    }
    
    public function getGenderName($linha) {
        $nomeGenero = $this->generoSexualController->getById(
            $linha[Colunas::USUARIO_FK_GENERO_SEXUAL]
        )[Colunas::GENERO_SEXUAL_NOME];
        
        return $nomeGenero;            
    }
    
    private function construirObjetoUnidadeFederativa() {
        $unidadeFederativa = $this->unidadeFederativaController->construirObjetoPorId(
            $_POST[Colunas::CIDADE_FK_UNIDADE_FEDERATIVA]
        );
        
        return $unidadeFederativa;
    }
    
    private function construirObjetoCidade() {
        $cidade = new Cidade(
            NULL, $_POST[Colunas::CIDADE_NOME],
            $this->construirObjetoUnidadeFederativa()
        );
        
        $this->cidadeController->rotearInsercao($cidade);
        $array = $this->cidadeController->getId($cidade);
        $cidade->id = $array[Colunas::CIDADE_ID];
        
        return $cidade;
    }
    
    private function construirObjetoEndereco() {
        $endereco = new Endereco(
            NULL, $_POST[Colunas::ENDERECO_BAIRRO],
            $_POST[Colunas::ENDERECO_CEP], $_POST[Colunas::ENDERECO_LOGRADOURO],
            $_POST[Colunas::ENDERECO_NUMERO], $this->construirObjetoCidade()
        );
        
        $this->enderecoController->rotearInsercao($endereco);
        $array = $this->enderecoController->getId($endereco);
        $endereco->id = $array[Colunas::ENDERECO_ID];
        
        return $endereco;
    }
    
    private function construirObjetoGeneroSexual() {
        $generoSexual = $this->generoSexualController->construirObjetoPorId(
            $_POST[Colunas::USUARIO_FK_GENERO_SEXUAL]
        );
        
        return $generoSexual;
    }
    
    public function getAtivoById($id) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT ' . Colunas::USUARIO_ATIVO . ' FROM '
            . Colunas::USUARIO . ' WHERE ' . Colunas::USUARIO_ID . ' LIKE ?'
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
    
    public function setAtivoById($id, $ativo) {
        $sqlQuery = $this->conexao->prepare(
            'UPDATE ' . Colunas::USUARIO . ' SET '
            . Colunas::USUARIO_ATIVO . ' = ? WHERE ' . Colunas::USUARIO_ID . ' = ?'
        );
        
        return $sqlQuery->execute(
            array(
                $ativo, $id
            )
        );         
    }
    
    public function setSenhaByEmail($email, $senha) {
        $sqlQuery = $this->conexao->prepare(
            'UPDATE ' . Colunas::USUARIO . ' SET '
            . Colunas::USUARIO_SENHA . ' = ? WHERE ' . Colunas::USUARIO_LOGIN . ' LIKE ?'
        );
        
        return $sqlQuery->execute(
            array(
                md5($senha), $email
            )
        );
    }

}
