window.onload = function () {
    document.cadastrarUsuario.nome.focus();
    const form = document.getElementById("cadastrar-usuario");
    form.addEventListener("submit", validarUsuario);
}

function validarUsuario (event) {
    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;
    const senha2 = document.getElementById("senha2").value;

    if (nome == "") {
        document.getElementById('msg').innerHTML = "Preencha o campo Nome";
        event.preventDefault();
        document.cadastrarUsuario.nome.focus();
        exit();
    }

    if (email == "") {
        document.getElementById('msg').innerHTML = "Preencha o campo E-mail";
        event.preventDefault();
        document.cadastrarUsuario.email.focus();
        exit();
    }

    if (senha.length < 8) {
        document.getElementById('msg').innerHTML = "Senha deve ter pelo menos 8 caracteres";
        event.preventDefault();
        document.cadastrarUsuario.senha.focus();
        exit();
    }

    if (senha != senha2) {
        document.getElementById('msg').innerHTML = "Senhas diferentes";
        event.preventDefault();
        document.cadastrarUsuario.senha2.focus();
    }
}