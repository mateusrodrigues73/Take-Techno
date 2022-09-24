window.onload = function () {
    document.recuperarSenha.senha.focus();
    const form = document.getElementById("recuperar-senha");
    form.addEventListener("submit", validarUsuario);
}

function validarUsuario (event) {
    const senha = document.getElementById("senha").value;
    const senha2 = document.getElementById("senha2").value;

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