function validarImagemUsuario (event) {
    const imagem = document.getElementById("imagem").value;
    if (imagem == "") {
        document.getElementById('errorImage').innerHTML = "Selecione uma imagem";
        event.preventDefault();
    }
}

function validarNomeUsuario (event) {
    const nome = document.getElementById("nome").value;
    if (nome == "") {
        document.getElementById('errorName').innerHTML = "Preencha o campo Nome";
        event.preventDefault();
        document.nomeUsuario.nome.focus();
    }
}

function validarSenhaUsuario (event) {
    const senhaAtual = document.getElementById("senha-atual").value;
    const senhaNova = document.getElementById("senha-nova").value;
    const senhaNova2 = document.getElementById("senha-nova2").value;
    
    if (senhaAtual == "") {
        document.getElementById('errorPassword').innerHTML = "Preencha o campo senha atual";
        event.preventDefault();
        document.senhaUsuario.senhaAtual.focus();
        exit();
    }

    if (senhaNova == "") {
        document.getElementById('errorPassword').innerHTML = "Preencha o campo nova senha";
        event.preventDefault();
        document.senhaUsuario.senhaNova.focus();
        exit();
    }

    if (senhaNova.length < 8) {
        document.getElementById('errorPassword').innerHTML = "Senha deve ter pelo menos 8 caracteres";
        event.preventDefault();
        document.senhaUsuario.senhaNova.focus();
        exit();
    }

    if (senhaNova != senhaNova2) {
        document.getElementById('errorPassword').innerHTML = "Senhas diferentes";
        event.preventDefault();
        document.senhaUsuario.senhaNova2.focus();
    }
}

function validarEnderecoUsuario (event) {
    const estado = document.getElementById("estado").value;
    const cidade = document.getElementById("cidade").value;
    const logradouro = document.getElementById("logradouro").value;

    if (estado == "") {
        document.getElementById('errorAddress').innerHTML = "Preencha o campo Estado";
        event.preventDefault();
        document.enderecoUsuario.estado.focus();
        exit();
    }

    if (cidade == "") {
        document.getElementById('errorAddress').innerHTML = "Preencha o campo Cidade";
        event.preventDefault();
        document.enderecoUsuario.cidade.focus();
        exit();
    }

    if (logradouro == "") {
        document.getElementById('errorAddress').innerHTML = "Preencha o campo Logradouro";
        event.preventDefault();
        document.enderecoUsuario.logradouro.focus();
    }
}