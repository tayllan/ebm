<?php

require_once DIR_ROOT . 'controller/database.php';
require_once DIR_ROOT . 'controller/produtoController.php';
require_once DIR_ROOT . 'controller/itemDeProdutoController.php';
require_once DIR_ROOT . 'controller/compraController.php';

class CartaoDeCreditoController extends DAO {

    private $usuario;
    private $produtoController;
    private $itemDeProdutoController;
    private $compraController;

    public function __construct() {
        parent::__construct();
        $this->usuario = LoginController::getUsuarioLogado();
        $this->produtoController = new ProdutoController();
        $this->itemDeProdutoController = new ItemDeProdutoController();
        $this->compraController = new CompraController();
    }

    private function getValorTotalDaCompra() {
        $array = $this->listar();
        $arrayItensDeProdutosQuantidade = $_SESSION[Colunas::ITEM_DE_PRODUTO_QUANTIDADE];
        $index = 0;
        $totalCompra = 0;

        foreach ($array as $linha) {
            $produto = $this->produtoController->construirObjetoPorId(
                $linha[Colunas::PRODUTO_ID]
            );
            $itemDeProduto = $this->itemDeProdutoController->construirObjetoPorId(
                $linha[Colunas::ITEM_DE_PRODUTO_ID]
            );
            $itemDeProduto->quantidade = $arrayItensDeProdutosQuantidade[$index];
            $this->itemDeProdutoController->rotearInsercao($itemDeProduto);
            
            $produto->quantidade -= $itemDeProduto->quantidade;
            $this->produtoController->rotearInsercao($produto);            
            
            $totalCompra += $arrayItensDeProdutosQuantidade[$index++] * $itemDeProduto->preco;
        }
        
        $compra = $this->compraController->construirObjetoPorId($array['0'][Colunas::COMPRA_ID]);

        return $totalCompra + $compra->frete;
    }

    private function listar() {
        $sqlQuery = $this->conexao->prepare(
            'SELECT ' . Colunas::PRODUTO_ID . ', ' . Colunas::MARCA_DE_PRODUTO_NOME . ', '
            . Colunas::CATEGORIA_DE_PRODUTO_NOME . ', ' . Colunas::ITEM_DE_PRODUTO_ID . ', '
            . Colunas::COMPRA_ID . ' FROM '
            . Colunas::USUARIO . ', ' . Colunas::COMPRA . ', '
            . Colunas::ITEM_DE_PRODUTO . ', ' . Colunas::PRODUTO . ', '
            . Colunas::CATEGORIA_DE_PRODUTO . ', ' . Colunas::MARCA_DE_PRODUTO . ' WHERE '
            . Colunas::USUARIO_ID . ' = ? AND ' . Colunas::USUARIO_ID . ' = '
            . Colunas::COMPRA_FK_USUARIO . ' AND ' . Colunas::COMPRA_ID . ' = '
            . Colunas::ITEM_DE_PRODUTO_FK_COMPRA . ' AND ' . Colunas::ITEM_DE_PRODUTO_FK_PRODUTO . ' = '
            . Colunas::PRODUTO_ID . ' AND ' . Colunas::COMPRA_CONCLUIDA . ' = FALSE AND '
            . Colunas::PRODUTO_FK_MARCA . ' = ' . Colunas::MARCA_DE_PRODUTO_ID . ' AND '
            . Colunas::PRODUTO_FK_CATEGORIA . ' = ' . Colunas::CATEGORIA_DE_PRODUTO_ID
        );

        $sqlQuery->execute(
            array($this->usuario->id)
        );

        if ($sqlQuery->rowCount() > 0) {
            return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
        }
        else {
            return array();
        }
    }

    public function construirFormularioCartao() {
        $totalCompra = $this->getValorTotalDaCompra();
        $endereco = $this->usuario->endereco->bairro . ' - ' . $this->usuario->endereco->logradouro
            . ', ' . $this->usuario->endereco->numero;
        
        $conteudo = '<form class="ui form" action="/view/cartaoDeCreditoView.php" method="POST">
            <fieldset class="ui form segment">
                <legend>Informações Gerais:</legend>

                <div>
                    <label>Valor total da compra</label>
                    <div class="ui left labeled icon input">
                        <input type="number" placeholder="E-Mail" value="' . $totalCompra . '">
                        <i class="dollar icon"></i>
                    </div>
                </div>

                <div>
                    <label>Comprador</label>
                    <div class="ui left labeled icon input">
                        <input type="text" value="' . $this->usuario->nome . '">
                        <i class="user icon"></i>
                    </div>
                </div>

                <div>
                    <label>Endereço de Entrega</label>
                    <div class="ui left labeled icon input">
                        <input type="text" value="' . $endereco . '">
                        <i class="map icon"></i>
                    </div>
                </div>
            </fieldset>

            <fieldset class="ui form segment">
                <legend>Informações de Cartão de Crédito</legend>
                
                <div>
                    <label>Titular do Cartão de Crédito</label>
                    <div class="ui left labeled icon input field">
                        <input type="text" name="nomeTitular" value="' . $this->usuario->nome . '">
                        <i class="user icon"></i>
                        <div class="ui red corner label">
                            <i class="icon asterisk"></i>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label>CPF do Titular</label>
                    <div class="ui left labeled icon input field">
                        <input type="text" name="cpfTitular" value="' . $this->usuario->cpf . '">
                        <i class=" icon"></i>
                        <div class="ui red corner label">
                            <i class="icon asterisk"></i>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label>Número do Cartão de Crédito</label>
                    <div class="ui left labeled icon input field">
                        <input type="text" name="numeroCartao">
                        <i class="icon"></i>
                        <div class="ui red corner label">
                            <i class="icon asterisk"></i>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label>Código Verificador</label>
                    <div class="ui left labeled icon input field">
                        <input type="number" maxlength="3" name="codVerificador">
                        <i class=" icon"></i>
                        <div class="ui red corner label">
                            <i class="icon asterisk"></i>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label>Data de Validade do Cartão</label>
                    <div class="ui left labeled icon input field">
                        <input type="date" name="validadeCartao">
                        <i class="calendar icon"></i>
                        <div class="ui red corner label">
                            <i class="icon asterisk"></i>
                        </div>
                    </div>
                </div>
            </fieldset>
            
            <div>
                <button type="submit" name="submeter" class="ui black submit button small">
                    Finalizar Compra
                </button>
            </div>
            
            <input type="hidden" name="compraSucesso">
        </form>
        <script>
        $(".ui.form").form(
            {
                nome: {
                    identifier: "nomeTitular",
                    rules: [
                        emptyRule
                  ]
                },
                cpf: {
                    identifier: "cpfTitular",
                    rules: [
                        cpfRule
                  ]
                },
                numeroCartao: {
                    identifier: "numeroCartao",
                    rules: [
                        emptyRule
                  ]
                },
                codVerificador: {
                    identifier: "codVerificador",
                    rules: [
                        threeCharacterRule
                    ]
                },
                validadeCartao: {
                    identifier: "validadeCartao",
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
    
    public function finalizarCompra() {
        $array = $this->listar();
        $arrayItensDeProdutosQuantidade = $_SESSION[Colunas::ITEM_DE_PRODUTO_QUANTIDADE];
        $index = 0;
        $totalCompra = 0;

        foreach ($array as $linha) {
            $produto = $this->produtoController->construirObjetoPorId(
                $linha[Colunas::PRODUTO_ID]
            );
            $itemDeProduto = $this->itemDeProdutoController->construirObjetoPorId(
                $linha[Colunas::ITEM_DE_PRODUTO_ID]
            );
            $itemDeProduto->quantidade = $arrayItensDeProdutosQuantidade[$index];
            $this->itemDeProdutoController->rotearInsercao($itemDeProduto);
            
            $produto->quantidade -= $itemDeProduto->quantidade;
            $this->produtoController->rotearInsercao($produto);            
            
            $totalCompra += $arrayItensDeProdutosQuantidade[$index++] * $itemDeProduto->preco;
        }
        
        $compra = $this->compraController->construirObjetoPorId($array['0'][Colunas::COMPRA_ID]);
        
        $compra->concluida = TRUE;
        $compra->total = $totalCompra + $compra->frete;
        $compra->formaPagamento = 'Cartão de Crédito';
        
        $this->compraController->rotearInsercao($compra);
    }

}
