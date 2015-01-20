<?php

require_once 'baseView.php';
require_once DIR_ROOT . 'controller/enderecoController.php';
require_once DIR_ROOT . 'controller/cidadeController.php';
require_once DIR_ROOT . 'entity/enderecoModel.php';
require_once DIR_ROOT . 'entity/cidadeModel.php';
require_once DIR_ROOT . 'view/template/enderecoEdicao.php';

class EnderecoView extends BaseView {

    public function __construct() {
        $this->controller = new EnderecoController();
        if ($this->controller->testarLoginAdministrador()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::ENDERECO_ID])) {
            $cidadeId = $this->controller->getCidadeId(
                $_POST[Colunas::CIDADE_NOME], $_POST[Colunas::CIDADE_FK_UNIDADE_FEDERATIVA]
            );
            $endereco = $this->controller->construirObjeto(
                array (
                    Colunas::ENDERECO_ID => $_POST[Colunas::ENDERECO_ID],
                    Colunas::ENDERECO_BAIRRO => $_POST[Colunas::ENDERECO_BAIRRO],
                    Colunas::ENDERECO_CEP => $_POST[Colunas::ENDERECO_CEP],
                    Colunas::ENDERECO_LOGRADOURO => $_POST[Colunas::ENDERECO_LOGRADOURO],
                    Colunas::ENDERECO_NUMERO => $_POST[Colunas::ENDERECO_NUMERO],
                    Colunas::ENDERECO_FK_CIDADE => $cidadeId
                )
            );
            $trueFalse = $this->controller->rotearInsercao($endereco);
            $this->exibirMensagemCadastro(
                'Endereço', $trueFalse
            );
        }
        else if (isset($_POST['editar']) && $_POST['editar'] === 'false') {
            $this->cadastrar();
        }
        else if (isset($_POST['editar'])) {
            $this->alterar();
        }
        else if (isset($_POST['deletar'])) {
            $this->deletar(
                'Endereço', Colunas::ENDERECO_ID,
                Colunas::ENDERECO
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $endereco = Endereco::getNullObject();
        $this->exibirConteudo(
            construirFormulario($endereco)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::ENDERECO);
        $conteudo = criarTabela(
            'Endereços Cadastrados', 'enderecoView',
            array(
                'Bairro', 'CEP',
                'Logradouro', 'Número',
                'Cidade'
            )
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table></form><script>paginarTabela()</script>');
    }
    
    protected function construirTabela($linha) {
        $conteudo = '<tr><td><button type="submit" name="editar" '
            . 'value="' . $linha[Colunas::ENDERECO_ID] . '" '
            . 'class="ui black submit button small"><i class="edit icon"></i></button></td>'
            . '<td>' . $linha[Colunas::ENDERECO_BAIRRO] . '</td>'
            . '<td>' . $linha[Colunas::ENDERECO_CEP] . '</td>'
            . '<td>' . $linha[Colunas::ENDERECO_LOGRADOURO] . '</td>'
            . '<td>' . $linha[Colunas::ENDERECO_NUMERO] . '</td>'
            . '<td>' . $this->controller->getCityName($linha) . '</td>'
            . '<td><button type="submit" name="deletar" '
            . 'value="' . $linha[Colunas::ENDERECO_ID] . '" '
            . 'class="ui red submit button small" onclick="return confirmarDelecao()">'
            . '<i class="delete icon"></i></button></td></tr>';
        
        return $conteudo;
    }

    protected function alterar() {
        $endereco = $this->controller->construirObjetoPorId($_POST['editar']);

        $this->exibirConteudo(
            construirFormulario($endereco)
        );
    }
    
    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Endereços');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new EnderecoView();
