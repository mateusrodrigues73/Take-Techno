window.onload = function () {
    document.logarUsuario.email.focus();
    const form = document.getElementById("logar-usuario");
    form.addEventListener("submit", validarUsuario);
}

function validarUsuario (event) {
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;

    if (email == "") {
        document.getElementById('msg').innerHTML = "Preencha o campo E-mail";
        event.preventDefault();
        document.logarUsuario.email.focus();
        exit();
    }

    if (senha == "") {
        document.getElementById('msg').innerHTML = "Preencha o campo Senha";
        event.preventDefault();
        document.logarUsuario.senha.focus();
        exit();
    }
}