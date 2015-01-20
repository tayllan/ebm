<?php

require_once 'baseView.php';
require_once DIR_ROOT . 'controller/generoSexualController.php';
require_once DIR_ROOT . 'entity/generoSexualModel.php';
require_once DIR_ROOT . 'view/template/generoSexualEdicao.php';

class GeneroSexualView extends BaseView {

    public function __construct() {
        $this->controller = new GeneroSexualController();
        if ($this->controller->testarLoginAdministrador()) {
            $this->rotear();
        }
    }

    protected function rotear() {
        if (isset($_POST[Colunas::GENERO_SEXUAL_ID])) {
            $generoSexual = $this->controller->construirObjeto(
                array (
                    Colunas::GENERO_SEXUAL_ID => $_POST[Colunas::GENERO_SEXUAL_ID],
                    Colunas::GENERO_SEXUAL_NOME=> $_POST[Colunas::GENERO_SEXUAL_NOME]
                )
            );
            $trueFalse = $this->controller->rotearInsercao($generoSexual);
            $this->exibirMensagemCadastro(
                'Gênero Sexual', $trueFalse
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
                'Gênero Sexual', Colunas::GENERO_SEXUAL_ID,
                Colunas::GENERO_SEXUAL
            );
        }
        else {
            $this->listar();
        }
    }

    protected function cadastrar() {
        $generoSexual = GeneroSexual::getNullObject();
        $this->exibirConteudo(
            construirFormulario($generoSexual)
        );
    }

    protected function listar() {
        $array = $this->controller->listar(Colunas::GENERO_SEXUAL);
        $conteudo = criarTabela(
            'Gêneros Sexuais Cadastrados', 'generoSexualView',
            array('Nome')
        );

        foreach ($array as $linha) {
            $conteudo .= $this->construirTabela($linha);
        }

        $this->exibirConteudo($conteudo . '</tbody></table></form><script>paginarTabela()</script>');
    }
    
    protected function construirTabela($linha) {
        $conteudo = '<tr><td><button type="submit" name="editar" '
            . 'value="' . $linha[Colunas::GENERO_SEXUAL_ID] . '" '
            . 'class="ui black submit button small"><i class="edit icon"></i></button></td>'
            . '<td>' . $linha[Colunas::GENERO_SEXUAL_NOME] . '</td>'
            . '<td><button type="submit" name="deletar" '
            . 'value="' . $linha[Colunas::GENERO_SEXUAL_ID] . '" '
            . 'class="ui red submit button small" onclick="return confirmarDelecao()">'
            . '<i class="delete icon"></i></button></td></tr>';
        
        return $conteudo;
    }

    protected function alterar() {
        $generoSexual = $this->controller->construirObjetoPorId($_POST['editar']);
        
        $this->exibirConteudo(
            construirFormulario($generoSexual)
        );
    }
    
    protected function exibirConteudo($conteudo) {
        cabecalhoHTML('Cadastro de Gêneros Sexuais');
        cabecalho('Super Cabeçalho');
        echo $conteudo;
        rodape('Super Rodapé');
        rodapeHTML();
    }

}

new GeneroSexualView();