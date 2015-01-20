<?php

require_once 'baseView.php';
require_once DIR_ROOT . 'controller/usuarioController.php';
require_once DIR_ROOT . 'controller/enderecoController.php';
require_once DIR_ROOT . 'controller/generoSexualController.php';
require_once DIR_ROOT . 'entity/usuarioModel.php';
require_once DIR_ROOT . 'entity/enderecoModel.php';
require_once DIR_ROOT . 'entity/generoSexualModel.php';
require_once DIR_ROOT . 'view/template/usuarioEdicao.php';

class UsuarioView extends BaseView {

    public function __construct() {
        $this->controller = new UsuarioController();
        if ($this->controller->testarLoginAdministrador()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::USUARIO_ID])) {
            $usuario = $this->controller->construirObjeto(
                array (
                    Colunas::USUARIO_ID => $_POST[Colunas::USUARIO_ID],
                    Colunas::USUARIO_NOME => $_POST[Colunas::USUARIO_NOME],
                    Colunas::USUARIO_LOGIN => $_POST[Colunas::USUARIO_LOGIN],
                    Colunas::USUARIO_SENHA => $_POST[Colunas::USUARIO_SENHA],
                    Colunas::USUARIO_CPF => $_POST[Colunas::USUARIO_CPF],
                    Colunas::USUARIO_TELEFONE => $_POST[Colunas::USUARIO_TELEFONE],
                    Colunas::USUARIO_DATA_DE_NASCIMENTO => $_POST[Colunas::USUARIO_DATA_DE_NASCIMENTO],
                    Colunas::USUARIO_ADMINISTRADOR => $_POST[Colunas::USUARIO_ADMINISTRADOR],
                    Colunas::USUARIO_ATIVO => $_POST[Colunas::USUARIO_ATIVO]
                )
            );
            $trueFalse = $this->controller->rotearInsercao($usuario);
            $this->exibirMensagemCadastro(
                'Usuario', $trueFalse
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
                'Usuario', Colunas::USUARIO_ID,
                Colunas::USUARIO
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $usuario = Usuario::getNullObject();
        $this->exibirConteudo(
            construirFormulario($usuario)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::USUARIO);
        $conteudo = criarTabela(
            'Usuarios Cadastrados', 'usuarioView',
            array(
                'Nome', 'Login',
                'Senha', 'CPF',
                'Telefone', 'Data de Nascimento',
                'Admin?', 'Endereço',
                'Gênero Sexual', 'Ativo?'
            )
        );

        foreach ($array as $linha) {
            $linha[Colunas::USUARIO_ADMINISTRADOR] = ajustarPermissao($linha[Colunas::USUARIO_ADMINISTRADOR]);
            $linha[Colunas::USUARIO_ATIVO] = ajustarAtivo($linha[Colunas::USUARIO_ATIVO]);
            
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table></form><script>paginarTabela()</script>');
    }
    
    protected function construirTabela($linha) {
        $conteudo = '<tr><td><button type="submit" name="editar" '
            . 'value="' . $linha[Colunas::USUARIO_ID] . '" '
            . 'class="ui black submit button small"><i class="edit icon"></i></button></td>'
            . '<td>' . $linha[Colunas::USUARIO_NOME] . '</td>'
            . '<td>' . $linha[Colunas::USUARIO_LOGIN] . '</td>'
            . '<td>********</td>'
            . '<td>' . $linha[Colunas::USUARIO_CPF] . '</td>'
            . '<td>' . $linha[Colunas::USUARIO_TELEFONE] . '</td>'
            . '<td>' . $linha[Colunas::USUARIO_DATA_DE_NASCIMENTO] . '</td>'
            . '<td>' . $linha[Colunas::USUARIO_ADMINISTRADOR] . '</td>'
            . '<td>' . $this->controller->getAddressName($linha) . '</td>'
            . '<td>' . $this->controller->getGenderName($linha) . '</td>'
            . '<td>' . $linha[Colunas::USUARIO_ATIVO] . '</td>'
            . '<td><button type="submit" name="deletar" '
            . 'value="' . $linha[Colunas::USUARIO_ID] . '" '
            . 'class="ui red submit button small" onclick="return confirmarDelecao()">'
            . '<i class="delete icon"></i></button></td></tr>';
        
        return $conteudo;
    }

    protected function alterar() {
        $usuario = $this->controller->construirObjetoPorId($_POST['editar']);

        $this->exibirConteudo(
            construirFormulario($usuario)
        );
    }
    
    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Usuarios');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new UsuarioView();
