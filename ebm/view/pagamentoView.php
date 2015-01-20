<?php

require_once '../config.php';
require_once DIR_ROOT . 'controller/loginController.php';
require_once DIR_ROOT . 'controller/pagamentoController.php';

class PagamentoView {

    public function __construct() {
        if (LoginController::testarLogin()) {
            $this->rotear();
        }
        else {
            $_SESSION[Colunas::ITEM_DE_PRODUTO_QUANTIDADE] = $_POST[Colunas::ITEM_DE_PRODUTO_QUANTIDADE];
            $_SESSION[Colunas::ITEM_DE_PRODUTO_ID] = $_POST[Colunas::ITEM_DE_PRODUTO_ID];
            $_SESSION[Colunas::PRODUTO_ID] = $_POST[Colunas::PRODUTO_ID];
            LoginController::exibirConteudo(
                LoginController::construirFormulario('/view/carrinhoDeComprasView.php')
            );
        }
    }

    private function rotear() {
        if (isset($_POST[Colunas::PRODUTO_ID])) {
            $this->exibirConteudo($this->contruirFormulario());
            $_SESSION[Colunas::ITEM_DE_PRODUTO_QUANTIDADE] = $_POST[Colunas::ITEM_DE_PRODUTO_QUANTIDADE];
        }
        else {
            if ($_POST['pagamento'] === 'boleto') {
                header('Location: boletoBancarioView.php');
            }
            else {
                header('Location: cartaoDeCreditoView.php');
            }
        }
    }

    private function contruirFormulario() {
        $conteudo = '<form class="ui form segment" action="/view/pagamentoView.php" method="POST">
            <div class="grouped inline fields">
                <span class="ui top attached label">Escolha sua forma de pagamento:</span>
                <br>
                    
                <div class="field">
                    <div class="ui radio checkbox">
                        <input id="boleto" type="radio" name="pagamento" value="boleto" checked>
                        <label for="boleto">Boleto Bancário</label>
                    </div>
                </div>
    
                <div class="field">
                    <div class="ui radio checkbox">
                        <input id="cartao" type="radio" name="pagamento" value="cartao">
                        <label for="cartao">Cartão de Crédito</label>
                    </div>
                </div>
            </div>
            
            <div>
                <input type="submit" name="pagar" value="Pagar" class="ui black submit button small">
            </div>
        </form>';

        return $conteudo;
    }

    private function exibirConteudo($conteudo) {
        cabecalhoHTML('Formas de Pagamento');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new PagamentoView();
