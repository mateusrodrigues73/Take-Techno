function cadastrarEndereco () {
    cep = document.getElementById("cep").value;
    if (cep != "") {
        fetch (`https://viacep.com.br/ws/${cep}/json/`)
        .then ((resp) => resp.json())
        .then ((data) => {
            let formData = new FormData();
            formData.append("estado", data.uf);
            formData.append("cidade", data.localidade);
            formData.append("logradouro", data.logradouro);
            fetch ("https://localhost/my-project/controllers/userController.php?action=true", {
            body: formData,
            method: "post",
            })
            .then ((resp) => resp.json())
            .then ((data) => {
                document.getElementById('errorAddress').innerHTML = "Endereço cadastrado com sucesso";
                setTimeout(() => {
                    window.location.reload(true);
                }, "2000")
            })
        })
        .catch ((error) => {
            document.getElementById('errorAddress').innerHTML = "CEP inválido";
        });
    }
    else {
        document.getElementById('errorAddress').innerHTML = "Preencha o campo CEP";
    }    
}