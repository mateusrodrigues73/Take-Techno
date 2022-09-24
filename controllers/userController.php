<?php

    require_once('../configuration/connect.php');
    require_once('../models/user.php');
    require_once('../models/product.php');
    session_start();

    if (isset($_POST['logar'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $array = array($email);
        $usuario = selectUser($connect, $array, $query);
        if ($usuario) {
            if (password_verify($senha, $usuario['senha'])) {
                if (!$usuario['status']) {
                    $_SESSION['msg'] = "Você ainda não confirmou seu e-mail";
                    header('location:../login.php');
                }
                else {
                    $_SESSION['idUsuario'] = $usuario['idUsuarios'];
                    $_SESSION['nome'] = $usuario['nome'];
                    $_SESSION['logado'] = true;
                    header('location:../index.php');
                }
            }
            else {
                $_SESSION['msg'] = "E-mail ou senha inválidos!";
                header('location:../login.php');
            }
        } 
        else {
            $_SESSION['msg'] = "E-mail ou senha inválidos!";
            header('location:../login.php');
        }
    }


    if (isset($_POST['cadastrar'])) {
        $email = $_POST['email'];
        $query = "SELECT email FROM usuarios WHERE email = ?";
        $array = array($email);
        $usuarioEmail = selectUser($connect, $array, $query);
        if (!$usuarioEmail) {
            $nome = $_POST['nome'];
            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $query = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
            $array = array($nome, $email, $senha);
            $retorno = insertUser($connect, $array, $query);
            if ($retorno) {
                $hash = md5($email);
                $link = "<a href='localhost/my-project/controllers/userController.php?h=".$hash."'> Clique aqui para confirmar seu cadastro </a>";
                $mensagem.="Email de Confirmação <br>".$link."</td></tr>";
		        $assunto="Confirme seu cadastro";
                $retorno= sendEmail($email, $mensagem, $assunto);
                if($retorno) {
                    $_SESSION['msg'] = "Confirme seu cadastro por email antes de continuar";
                    header('location:../login.php');
                }
                else {
                    $_SESSION['msg'] = "Email inválido";
                    header('location:../cadastrarUsuario.php');
                }
            }
        }
        else {
            $_SESSION['msg'] = "E-mail já cadastrado";
            header('location:../cadastrarUsuario.php');
        }
    }


    if(isset($_GET['h'])) {
        $h = $_GET['h'];
        $query = "SELECT * FROM usuarios WHERE md5(email) = ?";
        $array = array($h);
        $usuario = selectUser($connect, $array, $query);
        if ($usuario) {
            $query = "UPDATE usuarios SET status = true WHERE idUsuarios = ?";
            $array = array($usuario['idUsuarios']);
            $retorno = updateUser($connect, $array, $query);
            if ($retorno) {
                $_SESSION["msg"] = "Cadastro validado com sucesso";
            }
            else {
                $_SESSION["msg"] = "Erro ao validar usuário";
            }
        }
        else {
            $_SESSION["msg"] = "Erro ao validar usuário";
        }
        header('location:../login.php');
    } 


    if (isset($_POST['recuperarSenha'])) {
        $email = $_POST['email'];
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $array = array($email);
        $usuario = selectUser ($connect, $array, $query);
        if ($usuario) {
            $idUsuarios = $usuario['idUsuarios'];
            $confirmacao = sha1(uniqid(mt_rand(), true));
            $query = "INSERT INTO confirmacao (confirmacao, idUsuarios) VALUES (?, ?)";
            $array = array($confirmacao, $idUsuarios);
            $retorno = updateUser($connect, $array, $query);
            if ($retorno) {
                $link = "<a href='localhost/my-project/controllers/userController.php?email=".$email."&confirmacao=".$confirmacao."'> Clique aqui para alterar sua senha </a>";
                $mensagem="Clique no link para alterar sua senha <br>".$link."</td></tr>";
                $assunto="Recuperar senha";
                $retorno= sendEmail($email, $mensagem, $assunto);
                if ($retorno) {
                    $_SESSION['msg'] = "Verifique seus e-mails";
                    header('location:../login.php');
                }
                else {
                    $_SESSION['msg'] = "Falha ao enviar email";
                    header('location:../recuperarCadastro.php');
                }
            }
            else {
                $_SESSION['msg'] = "Falha ao enviar email";
                header('location:../recuperarCadastro.php');
            }
        }
        else {
            $_SESSION['msg'] = "E-mail não cadastrado";
            header('location:../recuperarCadastro.php');
        }
    }


    if (isset($_GET['confirmacao'])) {
        $_SESSION['confirmacao'] = $_GET['confirmacao'];
        $_SESSION['email'] = $_GET['email'];
        header('location:../recuperarSenha.php');
    }


    if (isset($_POST['recuperarCadastro'])) {
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $confirmacao = $_SESSION['confirmacao'];
        $email = $_SESSION['email'];
        $query = "UPDATE usuarios SET senha = ? WHERE email = ? AND idUsuarios IN (SELECT idUsuarios FROM confirmacao WHERE confirmacao = ?)";
        $array = array($senha, $email, $confirmacao);
        $retorno = updateUser($connect, $array, $query);
        if ($retorno) {
            $query = "DELETE FROM confirmacao WHERE confirmacao = ?";
            $array = array($confirmacao);
            updateUser($connect, $array, $query);
            unset($_SESSION['confirmacao']);
            $_SESSION['msg'] = "Senha alterada com sucesso";
            header('location:../login.php');
        }
        else {
            $_SESSION['msg'] = "Falha ao alterar senha";
            header('location:../recuperarSenha.php');
        }
    }


    if (isset($_POST['editarImagemUsario'])) {
        $imagemAntiga =  $_SESSION['imagem'];
        $idusuario = $_SESSION['idUsuario'];
        $imagem = $idusuario.$_FILES['imagem']['name'];
        $imagemTmp = $_FILES['imagem']['tmp_name'];
        $imagemSize = $_FILES['imagem']['size'];
        if ($imagemSize > 5000000) {
            $_SESSION['msg'] = "Imagem ".$imagem." deve ter no máximo 5mb";
            header('location:../perfil.php');
        }

        if (move_uploaded_file($imagemTmp, "../resources/images/users/$imagem")) {
            $query = "UPDATE usuarios SET imagem = ? WHERE idUsuarios = ?";
            $array = array($imagem, $idusuario); 
            $retorno = updateUser ($connect, $array, $query);
            if ($retorno) {
                if ($imagemAntiga != "user.png") {
                    unlink("../resources/images/users/$imagemAntiga");
                }
                unset($_SESSION['imagem']);
                $_SESSION['msg'] = "Imagem alterada com sucesso";
                header('location:../perfil.php');
            }
            else {
                $_SESSION['msg'] = "Falha ao alterar imagem";
                header('location:../perfil.php');
            }
        }
        else {
            $_SESSION['msg'] = "Falha ao alterar imagem ".$imagem;
            header('location:../perfil.php');  
        }
    }

    if (isset($_POST['editarNomeUsario'])) {
        $idusuario = $_SESSION['idUsuario'];
        $nome = $_POST['nome'];
        $query = "UPDATE usuarios SET nome = ? WHERE idUsuarios = ?";
        $array = array($nome, $idusuario); 
        $retorno = updateUser ($connect, $array, $query);
        if ($retorno) {
            $_SESSION['msg'] = "Nome alterado com sucesso";
            header('location:../perfil.php');
        }
        else {
            $_SESSION['msg'] = "Falha ao alterar nome";
            header('location:../perfil.php'); 
        }
    }

    if (isset($_POST['editarSenhaUsario'])) {
        $idusuario = $_SESSION['idUsuario'];
        $senhaAtual = $_POST['senhaAtual'];
        $senha = password_hash($_POST['senhaNova'], PASSWORD_DEFAULT);
        $query = "SELECT * FROM usuarios WHERE idusuarios = ?";
        $array = array($idusuario);
        $usuario = selectUser ($connect, $array, $query);
        if ($usuario) {
            if (password_verify($senhaAtual, $usuario['senha'])) {
                $query = "UPDATE usuarios SET senha = ? WHERE idUsuarios = ?";
                $array = array($senha, $idusuario); 
                $retorno = updateUser ($connect, $array, $query);
                if ($retorno) {
                    $_SESSION['msg'] = "Senha alterada com sucesso";
                    header('location:../perfil.php');
                }
                else {
                    $_SESSION['msg'] = "Falha ao alterar senha";
                    header('location:../perfil.php'); 
                }
            }
            else {
                $_SESSION['msg'] = "Senha atual incoreta";
                header('location:../perfil.php'); 
            }
        }
        else {
            $_SESSION['msg'] = "Falha ao alterar senha";
            header('location:../perfil.php'); 
        }
    }

    if(isset($_GET['action'])) {
        $idusuario = $_SESSION['idUsuario'];
        $estado = $_POST['estado'];
        $cidade = $_POST['cidade'];
        if (isset($_POST['logradouro'])) {
            $logradouro = $_POST['logradouro'];
        }
        else {
            $logradouro = "sem logradouro";
        }
        $query = "INSERT INTO enderecos (estado, cidade, logradouro, idUsuarios) values (?, ?, ?, ?)";
        $array = array($estado, $cidade, $logradouro, $idusuario);
        $retorno = updateUser ($connect, $array, $query);
        echo $retorno;
    }

    if(isset($_POST['deletarImagemUsario'])) {
        $idusuario = $_SESSION['idUsuario'];
        $imagem = $_SESSION['imagemUsuario'];
        $query = "UPDATE usuarios SET imagem = 'user.png' WHERE idUsuarios = ?";
        $array = array($idusuario);
        $retorno = updateUser ($connect, $array, $query);
        if ($retorno) {
            unlink("../resources/images/users/$imagem");
            $_SESSION['msg'] = "Imagem deletada com sucesso";
            header('location:../perfil.php');
        }
        else {
            $_SESSION['msg'] = "Falha ao deletar imagem";
            header('location:../perfil.php');
        }
        unset($_SESSION['imagem']);
    }

    if(isset($_POST['deletarEnderecoUsuario'])) {
        $idusuario = $_SESSION['idUsuario'];
        $query = "DELETE FROM enderecos WHERE idUsuarios = ?";
        $array = array($idusuario);
        $retorno = updateUser ($connect, $array, $query);
        if ($retorno) {
            $_SESSION['msg'] = "Endereço deletado com sucesso";
            header('location:../perfil.php');
        }
        else {
            $_SESSION['msg'] = "Falha ao deletar endereço";
            header('location:../perfil.php');
        }
    }

    if (isset($_POST['editarEnderecoUsario'])) {
        $idusuario = $_SESSION['idUsuario'];
        $estado = $_POST['estado'];
        $cidade = $_POST['cidade'];
        $logradouro = $_POST['logradouro'];
        $query = "UPDATE enderecos SET estado = ?, cidade = ?, logradouro = ? WHERE idUsuarios = ?";
        $array = array($estado, $cidade, $logradouro, $idusuario); 
        $retorno = updateUser ($connect, $array, $query);
        if ($retorno) {
            $_SESSION['msg'] = "Endereço alterado com sucesso";
            header('location:../perfil.php');
        }
        else {
            $_SESSION['msg'] = "Falha ao alterar endereço";
            header('location:../perfil.php'); 
        }
    }

    if(isset($_POST['deletarUsuario'])) {
        $idusuario = $_SESSION['idUsuario'];
        $imagem = $_SESSION['imagemUsuario'];
        $query = "DELETE FROM usuarios WHERE idUsuarios =?";
        $array = array($idusuario);
        $retorno = updateUser ($connect, $array, $query);
        if ($retorno) {
            if ($imagem != "user.png") {
                unlink("../resources/images/users/$imagem");
            }
            session_destroy();
            $_SESSION['msg'] = "Conta deletada com sucesso";
            header('location:../login.php');
        }
        else {
            $_SESSION['msg'] = "Falha ao deletar conta";
            header('location:../perfil.php');
        }
    }

    if(isset($_POST['comprarProduto'])) {
        $idusuario = $_SESSION['idUsuario'];
        $idproduto = $_SESSION['idproduto'];
        $idvendedor = $_SESSION['idvendedor'];

        $query = "SELECT * FROM produtos WHERE idProdutos = ?";
        $array = array($idproduto);
        $produto = selectProduct ($connect, $array, $query);

        $modelo = $produto['modelo'];
        $categoria = $produto['categoria'];
        $preco = $produto['preco'];
        
        $query = "INSERT INTO comprasusuarios (modelo, categoria, preco, idUsuarios, idVendedor) VALUES (?, ?, ?, ?, ?)";
        $array = array($modelo, $categoria, $preco, $idusuario, $idvendedor);
        $retorno = updateUser ($connect, $array, $query);
        if ($retorno) {
            $query = "INSERT INTO vendasusuarios (modelo, categoria, preco, idUsuarios) VALUES (?, ?, ?, ?)";
            $array = array($modelo, $categoria, $preco, $idvendedor);
            updateUser ($connect, $array, $query);
            $query = "UPDATE usuarios SET totalVendas = totalVendas + 1 WHERE idUsuarios = ?";
            $array = array($idvendedor);
            updateUser ($connect, $array, $query);

            $query = "DELETE FROM produtos WHERE idProdutos = ?";
            $array = array($idproduto);
            $retorno = updateProduct ($connect, $array, $query);
            if ($retorno) {
                $query = "SELECT * FROM imagensproduto WHERE idProdutos = ?";
                $imagens = selectProduct ($connect, $array, $query);

                $query = "DELETE FROM imagensprodutos WHERE idProdutos = ?";
                $retorno = updateProduct ($connect, $array, $query);
                if ($retorno) {
                    $imagem1 = $imagens['imagem1'];
                    $imagem2 = $imagens['imagem2'];
                    $imagem3 = $imagens['imagem3$imagem3'];
                    $imagem3 = $imagens['imagem3'];

                    unlink("../resources/images/products/$imagem1");
                    if (!$imagem2 == "") {
                        unlink("../resources/images/products/$imagem2");
                    }
                    if (!$imagem3 == "") {
                        unlink("../resources/images/products/$imagem3");
                    }
                    if (!$imagem4 == "") {
                        unlink("../resources/images/products/$imagem4");
                    }
                }
            }
            else {
                $_SESSION['msg'] = "Falha ao comprar produto";
                header('location:../produto.php');
            }
            $_SESSION['msg'] = "Produto comprado com sucesso";
            header('location:../compras.php');
        }   
        else {
            $_SESSION['msg'] = "Falha ao comprar produto";
            header('location:../produto.php');
        }
    }

    if(isset($_POST['avaliarVendedor'])) {
        $idvendedor = $_POST['idvendedor'];
        $avaliacao = $_POST['avaliacao'];
        
        $query = "INSERT INTO avaliacoes (avaliacao, idUsuarios) VALUES (?, ?)";
        $array = array($avaliacao, $idvendedor);
        $retorno = updateUser ($connect, $array, $query);
        if ($retorno) {
            $query = "SELECT AVG(avaliacao) FROM avaliacoes WHERE idUsuarios = ?";
            $array = array($idvendedor);
            $mediaAvaliacoes = selectUser ($connect, $array, $query);
            $mediaAvaliacoes = $mediaAvaliacoes['AVG(avaliacao)'];
            
            $query = "UPDATE usuarios SET avaliacoes = avaliacoes  + 1, mediaAvaliacoes = ? WHERE idUsuarios = ?";
            $array = array($mediaAvaliacoes, $idvendedor);
            $retorno = updateUser ($connect, $array, $query);
            if ($retorno) {
                $_SESSION['msg'] = "Avaliação eniada com sucesso";
                header('location:../compras.php');
            }
        }
        else {
            $_SESSION['msg'] = "Falha ao avaliar usuario";
            header('location:../compras.php');
        }
    }

    if(isset($_POST['deletarCompra'])) {
        $idcompra = $_POST['idcompra'];
        $query = "DELETE FROM comprasusuarios WHERE idComprasUsuarios = ?";
        $array = array($idcompra);
        $retorno = updateUser ($connect, $array, $query); 
        if ($retorno) {
            $_SESSION['msg'] = "Compra deletada com sucesso";
            header('location:../compras.php');
        }
        else {
            $_SESSION['msg'] = "Falha ao deletar compra";
            header('location:../compras.php');
        }
    }

    if(isset($_POST['deletarCompras'])) {
        $idusuario = $_SESSION['idUsuario'];
        $query = "DELETE FROM comprasusuarios WHERE idUsuarios = ?";
        $array = array($idusuario);
        $retorno = updateUser ($connect, $array, $query); 
        if ($retorno) {
            $_SESSION['msg'] = "Histórico de compras deletado com sucesso";
            header('location:../compras.php');
        }
        else {
            $_SESSION['msg'] = "Falha ao deletar histórico";
            header('location:../compras.php');
        }
    }

    if(isset($_POST['deletarVenda'])) {
        $idvenda = $_POST['idvenda'];
        $query = "DELETE FROM vendasusuarios WHERE idvendasUsuarios = ?";
        $array = array($idvenda);
        $retorno = updateUser ($connect, $array, $query); 
        if ($retorno) {
            $_SESSION['msg'] = "Venda deletada com sucesso";
            header('location:../vendas.php');
        }
        else {
            $_SESSION['msg'] = "Falha ao deletar venda";
            header('location:../vendas.php');
        }
    }

    if(isset($_POST['deletarVendas'])) {
        $idusuario = $_SESSION['idUsuario'];
        $query = "DELETE FROM vendasusuarios WHERE idUsuarios = ?";
        $array = array($idusuario);
        $retorno = updateUser ($connect, $array, $query); 
        if ($retorno) {
            $_SESSION['msg'] = "Histórico de vendas deletado com sucesso";
            header('location:../vendas.php');
        }
        else {
            $_SESSION['msg'] = "Falha ao deletar histórico";
            header('location:../vendas.php');
        }
    }
?>

