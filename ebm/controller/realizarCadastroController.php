<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/unidadeFederativaController.php';
require_once DIR_ROOT . 'controller/cidadeController.php';
require_once DIR_ROOT . 'controller/enderecoController.php';
require_once DIR_ROOT . 'controller/usuarioController.php';
require_once DIR_ROOT . 'controller/generoSexualController.php';
require_once DIR_ROOT . 'controller/loginController.php';

class RealizarCadastroController {

    private $unidadeFederativaController;
    private $cidadeController;
    private $enderecoController;
    private $usuarioController;
    private $generoSexualController;
    private $usuario;

    public function __construct() {
        $this->unidadeFederativaController = new UnidadeFederativaController();
        $this->cidadeController = new CidadeController();
        $this->enderecoController = new EnderecoController();
        $this->usuarioController = new UsuarioController();
        $this->generoSexualController = new GeneroSexualController();
        $this->usuario = Usuario::getNullObject();
    }

    public function inserir() {
        $unidadeFederativa = $this->construirObjetoUnidadeFederativa();
        $cidade = $this->construirObjetoCidade($unidadeFederativa);
        $endereco = $this->construirObjetoEndereco($cidade);
        $generoSexual = $this->construirObjetoGeneroSexual();
        $trueFalse = $this->construirObjetoUsuario($endereco, $generoSexual);
        
        return $trueFalse;
    }
    
    private function construirObjetoUnidadeFederativa() {
        $unidadeFederativa = $this->unidadeFederativaController->construirObjetoPorId(
            $_POST[Colunas::CIDADE_FK_UNIDADE_FEDERATIVA]
        );
        
        return $unidadeFederativa;
    }
    
    private function construirObjetoCidade($unidadeFederativa) {
        $cidade = new Cidade(
            NULL, $_POST[Colunas::CIDADE_NOME], $unidadeFederativa
        );
        
        $this->cidadeController->rotearInsercao($cidade);
        $array = $this->cidadeController->getId($cidade);
        $cidade->id = $array[Colunas::CIDADE_ID];
        
        return $cidade;
    }
    
    private function construirObjetoEndereco($cidade) {
        $endereco = new Endereco(
            NULL, $_POST[Colunas::ENDERECO_BAIRRO],
            $_POST[Colunas::ENDERECO_CEP], $_POST[Colunas::ENDERECO_LOGRADOURO],
            $_POST[Colunas::ENDERECO_NUMERO], $cidade
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
    
    private function construirObjetoUsuario($endereco, $generoSexual) {
        $this->usuario = new Usuario(
            $_POST[Colunas::USUARIO_ID], $_POST[Colunas::USUARIO_NOME],
            $_POST[Colunas::USUARIO_LOGIN], $_POST[Colunas::USUARIO_SENHA],
            $_POST[Colunas::USUARIO_CPF], $_POST[Colunas::USUARIO_TELEFONE],
            $_POST[Colunas::USUARIO_DATA_DE_NASCIMENTO], 'false',
            $endereco, $generoSexual,
            'true'
        );
        
        $trueFalse = $this->usuarioController->rotearInsercao($this->usuario);
        $array = $this->usuarioController->getId($this->usuario);
        $this->usuario->id = $array[Colunas::USUARIO_ID];
        
        return $trueFalse;
    }
    
    public function logarRedirecionar() {
        if ($_POST[Colunas::USUARIO_ID]) {
            header('Location: /view/perfilView.php');
        }
        else {
            LoginController::realizarLogin($this->usuario);
            header('Location: ../index.php');
        }
    }

}
