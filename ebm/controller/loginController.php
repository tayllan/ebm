<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once DIR_ROOT . 'controller/usuarioController.php';
require_once DIR_ROOT . 'entity/usuarioModel.php';
require_once DIR_ROOT . 'view/template/html.php';

class LoginController {

    public static $controller;
    public static $usuario;

    private function __construct() {
        
    }

    public static function realizarLogin($usuario) {
        $_SESSION[SESSAO_LOGADO] = true;
        $_SESSION[SESSAO_USUARIO_ID] = $usuario->id;
        $_SESSION[SESSAO_USUARIO_LOGIN] = $usuario->login;
    }

    public static function realizarLogout() {
        unset($_SESSION[SESSAO_LOGADO]);
        unset($_SESSION[SESSAO_USUARIO_ID]);
        unset($_SESSION[SESSAO_USUARIO_LOGIN]);
        unset($_SESSION[SESSAO_USUARIO_PERMISSAO]);
        unset($_SESSION[Colunas::PRODUTO_ID]);
    }

    public static function testarLogin() {
        if (isset($_SESSION[SESSAO_LOGADO])) {
            return true;
        }
        else {
            return false;
        }
    }
    
    public static function getUsuarioLogado() {
        if (LoginController::testarLogin()) {
            LoginController::$usuario = new UsuarioController();
            $usuario = LoginController::$usuario->construirObjetoPorId($_SESSION[SESSAO_USUARIO_ID]);
            
            return $usuario;
        }
        else {
            return NULL;
        }
    }

    public static function testarLoginAdministrador() {
        if (isset($_SESSION[SESSAO_USUARIO_PERMISSAO])) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function validarLoginComPermissao($usuario) {
        LoginController::$controller = new UsuarioController();
        if (LoginController::validarLogin($usuario)) {
            LoginController::realizarLogin(LoginController::$usuario);
            if (LoginController::validarPermissao()) {
                $_SESSION[SESSAO_USUARIO_PERMISSAO] = true;
                header('Location: paginaDoAdministrador.php');
            }
            else {
                $pagina = $_GET['paginaDestino'];
                header('Location: ' . $pagina);
            }
        }
        else {
            $_POST['erro'] = 'true';
        }
    }

    private static function validarLogin($usuario) {
        $array = LoginController::$controller->getId($usuario);

        if (!empty($array)) {
            $ativo = LoginController::$controller->getAtivoById(
                $array[Colunas::USUARIO_ID]
            )[Colunas::USUARIO_ATIVO];
            
            if ($ativo) {
                LoginController::$usuario->id = $array[Colunas::USUARIO_ID];
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    private static function validarPermissao() {
        $array = LoginController::$controller->getId(LoginController::$usuario);
        LoginController::$usuario->id = $array[Colunas::USUARIO_ID];
        $array = LoginController::$controller->getById(LoginController::$usuario->id);

        if (!empty($array) && $array[Colunas::USUARIO_ADMINISTRADOR]) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function construirFormulario($paginaDestino) {
        $conteudo = '<form action="/core/login.php?paginaDestino=' . $paginaDestino . '" 
            method="POST" class="ui form">
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
                        Logar
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

    public static function exibirConteudo($conteudo) {
        cabecalhoHTML('Tela de Login');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}