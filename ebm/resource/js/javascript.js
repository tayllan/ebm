var emptyRule = {
    type: "empty",
    prompt: "O campo não pode estar vazio!"
};

var emailRule = {
    type: "email",
    prompt: "Insira um e-mail válido."
};

var cpfRule = {
    type: "cpf",
    prompt: "CPF Inválido."
};

var twoCharacterRule = {
    type: "length[2]",
    prompt: "O campo deve possuir ao menos 2 caracteres."
};

var threeCharacterRule = {
    type: "length[3]",
    prompt: "O campo deve possuir ao menos 3 caracteres."
};

var fiveCharacterRule = {
    type: "length[5]",
    prompt: "O campo deve possuir ao menos 5 caracteres."
};

var eightCharacterRule = {
    type: "length[8]",
    prompt: "O campo deve conter 8 dígitos (sem nenhuma pontuação)."
};

var elevenCharacterRule = {
    type: "length[11]",
    prompt: "O campo deve possuir 11 dígitos (sem nenhuma pontuação)."
};

function validarSenha() {
    var senha = document.querySelector("[name=usuario_senha]");
    var confirmarSenha = document.querySelector("[name=confirmarSenha]");
    var confirmarSenhaError = document.querySelector("#confirmarSenhaError");
    var confirmarSenhaDiv = document.querySelector("#confirmarSenha");

    if (senha.value === confirmarSenha.value) {
        confirmarSenhaError.className = '';
        confirmarSenhaDiv.className = 'ui left labeled icon input field';

        return true;
    }
    else {
        confirmarSenhaError.className = 'ui red pointing prompt label transition visible';
        confirmarSenhaDiv.className += ' error'

        return false;
    }
};

function confirmarDelecao() {
    var resultado = confirm("Deseja mesmo deletar ?");

    if (resultado) {
        return true;
    }
    else {
        return false;
    }
};

function paginarTabela() {
    $("#tabela-paginada").dynatable(
            {
                features: {
                    pushState: true
                }
            }
    );
};

function validarCarrinhoDeCompras() {
    var td = document.querySelector('td');

    if (td === null) {
        alert('O Carrinho de Compras está VAZIO!');
        return false;
    }
    else {
        return true;
    }
};

function calcularValorItemDeProduto() {
    var preco = document.querySelectorAll("[name=preco]");
    var quantidade = document.querySelectorAll("#quantidade");

    for (var index = 0; index < preco.length; index++) {
        preco[index].value = Number(preco[index].id) * Number(quantidade[index].value);
    }
};


function validarCPF(cpf) {
    var naoDigito = /\D/;

    if (cpf.length < 11) {
        return false;
    }
    else if (naoDigito.test(cpf)) {
        return false;
    }
    else if (cpf === '00000000000' || cpf === '11111111111' ||
            cpf === '22222222222' || cpf === '33333333333' ||
            cpf === '44444444444' || cpf === '55555555555' ||
            cpf === '66666666666' || cpf === '77777777777' ||
            cpf === '88888888888' || cpf === '99999999999') {
        return false;
    }
    else {
        var resto = verificarDigitoCPF(cpf, 10);
        var primeiroDigitoVerificador = 11 - resto;

        if (resto < 2) {
            primeiroDigitoVerificador = 0;
        }

        if (Number(cpf.charAt(9)) !== primeiroDigitoVerificador) {
            return false;
        }
        else {
            resto = verificarDigitoCPF(cpf, 11);
            var segundoDigitoVerificador = 11 - resto;

            if (resto < 2) {
                segundoDigitoVerificador = 0;
            }

            if (Number(cpf.charAt(10)) !== segundoDigitoVerificador) {
                return false;
            }
            else {
                return true;
            }
        }
    }
};

function verificarDigitoCPF(cpf, indice) {
    var soma = 0;

    for (i = 0; indice > 1; indice--, i++) {
        soma += Number(cpf.charAt(i)) * indice;
    }

    return soma % 11;
};
