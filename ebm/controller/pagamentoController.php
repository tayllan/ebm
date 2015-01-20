<?php

require_once DIR_ROOT . 'controller/loginController.php';

class PagamentoController {

    private function getValorTotalDaCompra($arrayItensDeProdutosPreco, $arrayItensDeProdutosQuantidade) {
        $valorTotal = 0;
        $indice = 0;

        foreach ($arrayItensDeProdutosPreco as $preco) {
            $valorTotal += $preco * $arrayItensDeProdutosQuantidade[$indice++];
        }

        return $valorTotal;
    }
    
    public function logar() {
        
    }
    
    private function contruirFormularioLogar() {
        $conteudo = '<form action="/view/pagamentoView.php" method="POST">
            <fieldset>
                <legend>Logar</legend>
                
                <span>Para completar sua compra é necessário estar logado</span>
                
                <div>
                    <label for="email">E-Mail:</label>
                    <input type="text" id="email" name="' . Colunas::USUARIO_LOGIN . '">
                </div>

                <div>
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="' . Colunas::USUARIO_SENHA . '">
                </div>

                <div>
                    <input type="submit" name="submeter" value="Logar">
                </div>
            </fieldset>
        </form>';
        
        return $conteudo;
    }

}
