window.onload = function () {
    document.recuperarCadastro.email.focus();
    const form = document.getElementById("recuperar-cadastro");
    form.addEventListener("submit", validarUsuario);
}

function validarUsuario (event) {
    const email = document.getElementById("email").value;

    if (email == "") {
        document.getElementById('msg').innerHTML = "Preencha o campo E-mail";
        event.preventDefault();
        document.recuperarCadastro.email.focus();
    }
}