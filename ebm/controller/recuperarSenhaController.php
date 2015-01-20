<?php

require_once DIR_ROOT . 'controller/database.php';
require_once DIR_ROOT . 'controller/usuarioController.php';

class RecuperarSenhaController extends DAO {
    
    private $usuarioController;
    
    public function __construct() {
        parent::__construct();
        $this->usuarioController = new UsuarioController();
    }
    
    public function recuperarSenha($email) {
        $novaSenha = $this->senhaAleatoria();
        $trueFalse = $this->usuarioController->setSenhaByEmail(
            $email, $novaSenha
        );
        
        if ($trueFalse) {
            $assunto = 'Recuperacao de Senha';
            $conteudo = 'Sua nova senha é: ' . $novaSenha;
            
            $trueFalse = mail(
                $email, $assunto,
                $conteudo
            );
            
            return $trueFalse;
        }
        else {
            return $trueFalse;
        }
    }
    
    private function senhaAleatoria() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $stringAleatoria = '';

        for ($i = 0; $i < 10; $i++) {
            $stringAleatoria .= $characters[
                rand(
                    0, strlen($characters)
                )
            ];
        }
        return $stringAleatoria;
    }
    
}