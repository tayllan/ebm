<?php

require_once DIR_ROOT . 'controller/loginController.php';
require_once DIR_ROOT . 'controller/database.php';
require_once DIR_ROOT . 'controller/usuarioController.php';
require_once DIR_ROOT . 'controller/realizarCadastroController.php';
require_once DIR_ROOT . 'view/template/realizarCadastroEdicao.php';

class PerfilController extends DAO {
    
    private $usuario;
    private $cadastroController;
    
    public function __construct() {
        parent::__construct();
        $this->usuario = LoginController::getUsuarioLogado();
        $this->cadastroController = new RealizarCadastroController();
    }
    
    public function alterar() {
        return construirFormulario($this->usuario);
    }
    
    public function desativarUsuario() {
        $usuarioController = new UsuarioController();
        $usuarioController->setAtivoById($this->usuario->id, 0);
        LoginController::realizarLogout();
        header('Location: /index.php');
    }
    
    public function construirMenuDeCompras() {
        $array = $this->getComprasDoUsuario();
        $conteudo = '<div class="list">
            <div class="ui center aligned segment">
                <legend class="ui black label">Compras Realizadas</legend>
            </div>';
        
        foreach ($array as $linha) {
            $conteudo .= $this->construirListaDeCompras($linha);
        }
        
        return $conteudo . '</div>';
    }
    
    private function construirListaDeCompras($linha) {
        $conteudo = '<table class="ui table">
            <legend class="ui black label">Compra realizada em: ' . $linha[Colunas::COMPRA_DATA]
            . ' - Valor total: R$' . $linha[Colunas::COMPRA_TOTAL] . ' - Forma de pagamento: '
            . $linha[Colunas::COMPRA_FORMA_PAGAMENTO] . ' - Valor de Frete: R$ '
            . $linha[Colunas::COMPRA_FRETE] . '</legend>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Preço Total</th>
                </tr>
            </thead>
            <tbody>';
        $array = $this->getItensDeProdutosDaCompra(
            $linha[Colunas::COMPRA_ID]
        );
        
        foreach ($array as $miniLinha) {
            $conteudo .= $this->construirListaDeItensDeProdutos($miniLinha);
        }
        
        return $conteudo . '</tbody></table><br><br>';
    }
    
    private function construirListaDeItensDeProdutos($linha) {
        $conteudo = '<tr>
            <td>' . $linha[Colunas::PRODUTO_NOME] . '</td>
            <td>' . $linha[Colunas::ITEM_DE_PRODUTO_QUANTIDADE] . '</td>
            <td>' . $linha[Colunas::ITEM_DE_PRODUTO_PRECO] . '</td>
            <td>' . $linha[Colunas::ITEM_DE_PRODUTO_QUANTIDADE] * $linha[Colunas::ITEM_DE_PRODUTO_PRECO] . '</td>
        </tr>';
        
        return $conteudo;
    }
    
    private function getComprasDoUsuario() {
        $sqlQuery = $this->conexao->prepare(
            'SELECT * FROM ' . Colunas::COMPRA . ' WHERE ' . Colunas::COMPRA_FK_USUARIO
            . ' = ? AND ' . Colunas::COMPRA_CONCLUIDA . ' = 1'
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
    
    private function getItensDeProdutosDaCompra($compraId) {
        $sqlQuery = $this->conexao->prepare(
            'SELECT ' . Colunas::ITEM_DE_PRODUTO_QUANTIDADE . ', '
            . Colunas::ITEM_DE_PRODUTO_PRECO . ', ' . Colunas::PRODUTO_NOME . ' FROM '
            . Colunas::ITEM_DE_PRODUTO . ', ' . Colunas::PRODUTO . ' WHERE '
            . Colunas::ITEM_DE_PRODUTO_FK_COMPRA . ' = ? AND '
            . Colunas::ITEM_DE_PRODUTO_FK_PRODUTO . ' = ' . Colunas::PRODUTO_ID
        );
        
        $sqlQuery->execute(
            array($compraId)
        );
        
        if ($sqlQuery->rowCount() > 0) {
            return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
        }
        else {
            return array();
        }
    }
}