<?php

require_once '../config.php';
require_once DIR_ROOT . 'view/template/html.php';
require_once DIR_ROOT . 'controller/recuperarSenhaController.php';

class RecuperarSenhaView {
    
    private $controller;
    
    public function __construct() {
        $this->controller = new RecuperarSenhaController();
        $this->rotear();
    }
    
    private function rotear() {
        if (isset($_POST[Colunas::USUARIO_LOGIN])) {
            $trueFalse = $this->controller->recuperarSenha($_POST[Colunas::USUARIO_LOGIN]);
            
            if ($trueFalse) {
                $this->exibirConteudo('<p class="ui green label">Uma nova senha foi enviada ao seu e-mail!</p>');
            }
            else {
                $this->exibirConteudo(MENSAGEM_ERRO);
            }
        }
        else {
            $this->exibirConteudo(
            $this->construirFormulario()
            );
        }
    }
    
    private function construirFormulario() {
        $conteudo = '<form class="ui form segment" action="/view/recuperarSenhaView.php" method="POST">
            <fieldset>
                <legend>Recuperar Senha</legend>
                
                <div>
                    <label>E-Mail</label>
                    <div class="ui left labeled icon input field">
                        <input type="text" placeholder="E-Mail" name="' . Colunas::USUARIO_LOGIN . '">
                        <i class="mail icon"></i>
                        <div class="ui red corner label">
                            <i class="icon asterisk"></i>
                        </div>
                    </div>
                </div>
                
                <div>
                    <button type="submit" name="submeter" class="ui black submit button small">
                        <i class="forward mail icon"></i>
                        Recuperar
                    </button>
                </div>
            </fieldset>
        </form>
        <script>
        $(".ui.form").form(
            {
                email: {
                    identifier: "' . Colunas::USUARIO_LOGIN . '",
                    rules: [
                        emailRule
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
    
    private function exibirConteudo($conteudo) {
        cabecalhoHTML('Recuperar Senha');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }
    
}

new RecuperarSenhaView();