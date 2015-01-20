<?php

require_once DIR_ROOT . 'controller/usuarioController.php';
require_once DIR_ROOT . 'controller/loginController.php';
require_once DIR_ROOT . 'entity/usuarioModel.php';

class ReativarContaController {
    
    private $usuarioController;
    private $usuario;
    
    public function __construct() {
        $this->usuario = Usuario::getNullObject();
        $this->usuarioController = new UsuarioController();
    }

    public function reativar() {
        $this->usuario->login = $_POST[Colunas::USUARIO_LOGIN];
        $this->usuario->senha = $_POST[Colunas::USUARIO_SENHA];
        $array = $this->usuarioController->getId($this->usuario);
        
        if (!empty($array)) {
            $this->usuario->id = $array[Colunas::USUARIO_ID];
            $this->usuarioController->setAtivoById($this->usuario->id, 1);
            LoginController::realizarLogin($this->usuario);
            return true;
        }
        else {
            return false;
        }
    }
    
    public function construirFormulario() {
        $conteudo = '<form action="/view/reativarContaView.php" method="POST" class="ui form">
            <fieldset>
                <legend>Login</legend>
                
                <div>
                    <legend>E-Mail</legend>

                    <div class="ui left labeled icon input field">
                        <input type="text" placeholder="E-Mail" name="' . Colunas::USUARIO_LOGIN . '">
                        <i class="mail icon"></i>
                        <div class="ui red corner label">
                            <i class="icon asterisk"></i>
                        </div>
                    </div>
                </div>
                
                <div>
                    <legend>Senha</legend>

                    <div class="ui left labeled icon input field">
                        <input type="password" name="' . Colunas::USUARIO_SENHA . '">
                        <i class="lock icon"></i>
                        <div class="ui red corner label">
                            <i class="icon asterisk"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" name="submeter" class="ui black submit button small">
                        <i class="sign in icon"></i>
                        Reativar
                    </button>
                </div>
            </fieldset>
        </form>
        <script>
        $(\'.ui.form\').form(
            {
                email: {
                    identifier: "' . Colunas::USUARIO_LOGIN . '",
                    rules: [
                        emptyRule
                  ]
                },
                senha: {
                    identifier: "' . Colunas::USUARIO_SENHA . '",
                    rules: [
                        emptyRule
                  ]
                }
            },
            {
                inline: true
            }
        );
        </script>';

        return $conteudo;
    }
    
}