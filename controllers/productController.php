<?php

    require_once('../configuration/connect.php');
    require_once('../models/product.php');
    session_start();

    if (isset($_POST['cadastrar'])) {
        $idusuario = $_SESSION['idUsuario'];
        $modelo = $_POST['modelo'];
        $marca = $_POST['marca'];
        $categoria = $_POST['categorias'];
        $preco = $_POST['preco'];

        $imagem1 = $idusuario.$_FILES['imagem1']['name'];
        $imagem1Tmp = $_FILES['imagem1']['tmp_name'];
        $imagem1Size = $_FILES['imagem1']['size'];
        if ($imagem1Size > 5000000) {
            $_SESSION['msg'] = "Imagem ".$imagem1." deve ter no máximo 5mb";
            header('location:../cadastrarProduto.php');
        }

        $imagem2 = $idusuario.$_FILES['imagem2']['name'];
        $imagem2Tmp = $_FILES['imagem2']['tmp_name'];
        $imagem2Size = $_FILES['imagem2']['size'];
        if ($imagem2Size > 5000000) {
            $_SESSION['msg'] = "Imagem ".$imagem2." deve ter no máximo 5mb";
            header('location:../cadastrarProduto.php');
        }
        
        $imagem3 = $idusuario.$_FILES['imagem3']['name'];
        $imagem3Tmp = $_FILES['imagem3']['tmp_name'];
        $imagem3Size = $_FILES['imagem3']['size'];
        if ($imagem3Size > 5000000) {
            $_SESSION['msg'] = "Imagem ".$imagem3." deve ter no máximo 5mb";
            header('location:../cadastrarProduto.php');
        }

        $imagem4 = $idusuario.$_FILES['imagem4']['name'];
        $imagem4Tmp = $_FILES['imagem4']['tmp_name'];
        $imagem4Size = $_FILES['imagem4']['size'];
        if ($imagem4Size > 5000000) {
            $_SESSION['msg'] = "Imagem ".$imagem4." deve ter no máximo 5mb";
            header('location:../cadastrarProduto.php');
        }

        if (move_uploaded_file($imagem1Tmp, "../resources/images/products/$imagem1")) {
            $query = "INSERT INTO produtos (modelo, marca, categoria, preco, IdUsuarios) VALUES (?, ?, ?, ?, ?)";
            $array = array($modelo, $marca, $categoria, $preco, $idusuario);
            $retorno = insertProduct($connect, $array, $query);
            if ($retorno) {
                $query = "SELECT idProdutos FROM produtos WHERE idUsuarios = ? ORDER BY idProdutos DESC";
                $array = array($idusuario);
                $produto = selectProduct ($connect, $array, $query);
                $idproduto = $produto['idProdutos'];
                $query = "INSERT INTO imagensprodutos (imagem1, idProdutos) VALUES (?, ?)";
                $array = array($imagem1, $idproduto);
                insertProduct ($connect, $array, $query);

                if (!$imagem2 == "") {
                    if (move_uploaded_file($imagem2Tmp, "../resources/images/products/$imagem2")) {
                        $query = "UPDATE imagensprodutos SET imagem2 = ? WHERE idProdutos = ?";
                        $array = array($imagem2, $idproduto);
                        updateProduct ($connect, $array, $query);
                    } 
                    else {
                        $_SESSION['msg'] = "Falha ao cadastrar imagem ".$imagem2;
                        header('location:../anuncios.php');
                    }   
                }

                if (!$imagem3 == "") {
                    if (move_uploaded_file($imagem3Tmp, "../resources/images/products/$imagem3")) {
                        $query = "UPDATE imagensprodutos SET imagem3 = ? WHERE idProdutos = ?";
                        $array = array($imagem3, $idproduto);
                        updateProduct ($connect, $array, $query);
                    } 
                    else {
                        $_SESSION['msg'] = "Falha ao cadastrar imagem ".$imagem3;
                        header('location:../anuncios.php');
                    }   
                }

                if (!$imagem4 == "") {
                    if (move_uploaded_file($imagem4Tmp, "../resources/images/products/$imagem4")) {
                        $query = "UPDATE imagensprodutos SET imagem4 = ? WHERE idProdutos = ?";
                        $array = array($imagem4, $idproduto);
                        updateProduct ($connect, $array, $query);
                    } 
                    else {
                        $_SESSION['msg'] = "Falha ao cadastrar imagem ".$imagem4;
                        header('location:../anuncios.php');
                    }   
                }

                $_SESSION['msg'] = "Produto cadastrado com sucesso";
                header('location:../anuncios.php');
            }
            else {
                $_SESSION['msg'] = "Falha ao cadastrar produto";
                header('location:../cadastrarProduto.php');
            }
        }
    }
    

    if (isset($_POST['editar-produto'])) {
        $idusuario = $_SESSION['idUsuario'];
        $idproduto = $_SESSION['idproduto'];
        $modelo = $_POST['modelo'];
        $marca = $_POST['marca'];
        $preco = $_POST['preco'];
        $categoria = $_POST['categorias'];
        $excluirImagem2 = $_POST['excluirImagem2'];
        $excluirImagem3 = $_POST['excluirImagem3'];
        $excluirImagem4 = $_POST['excluirImagem4'];

        $imagem1 = $idusuario.$_FILES['imagem1']['name'];
        $imagem1Tmp = $_FILES['imagem1']['tmp_name'];
        $imagem1Size = $_FILES['imagem1']['size'];
        if ($imagem1Size > 5000000) {
            $_SESSION['msg'] = "Imagem ".$imagem1." deve ter no máximo 5mb";
            header('location:../editarProduto.php');
        }
        $imagem2 = $idusuario.$_FILES['imagem2']['name'];
        $imagem2Tmp = $_FILES['imagem2']['tmp_name'];
        $imagem2Size = $_FILES['imagem2']['size'];
        if ($imagem2Size > 5000000) {
            $_SESSION['msg'] = "Imagem ".$imagem2." deve ter no máximo 5mb";
            header('location:../editarProduto.php');
        }
        $imagem3 = $idusuario.$_FILES['imagem3']['name'];
        $imagem3Tmp = $_FILES['imagem3']['tmp_name'];
        $imagem3Size = $_FILES['imagem3']['size'];
        if ($imagem3Size > 5000000) {
            $_SESSION['msg'] = "Imagem ".$imagem3." deve ter no máximo 5mb";
            header('location:../editarProduto.php');
        }
        $imagem4 = $idusuario.$_FILES['imagem4']['name'];
        $imagem4Tmp = $_FILES['imagem4']['tmp_name'];
        $imagem4Size = $_FILES['imagem4']['size'];
        if ($imagem4Size > 5000000) {
            $_SESSION['msg'] = "Imagem ".$imagem4." deve ter no máximo 5mb";
            header('location:../editarProduto.php');
        }

        $query = "UPDATE produtos SET modelo = ?, marca = ?, categoria = ?, preco = ? WHERE idUsuarios = ?";
        $array = array($modelo, $marca, $categoria, $preco, $idusuario);
        $retorno = updateProduct($connect, $array, $query);
        if ($retorno) {
            if (!$imagem1 == "") {
                if (move_uploaded_file($imagem1Tmp, "../resources/images/products/$imagem1")) {
                    $excluirImagem = $_SESSION['imagem1'];
                    unlink("../resources/images/products/$excluirImagem");
                    $query = "UPDATE imagensprodutos SET imagem1 = ? WHERE idProdutos = ?";
                    $array = array($imagem1, $idproduto);
                    updateProduct ($connect, $array, $query);
                } 
                else {
                    $_SESSION['msg'] = "Falha ao cadastrar imagem ".$imagem1;
                    header('location:../anuncios.php');
                }   
            }

            if (!$imagem2 == "") {
                if (move_uploaded_file($imagem2Tmp, "../resources/images/products/$imagem2")) {
                    $excluirImagem = $_SESSION['imagem2'];
                    unlink("../resources/images/products/$excluirImagem");
                    $query = "UPDATE imagensprodutos SET imagem2 = ? WHERE idProdutos = ?";
                    $array = array($imagem2, $idproduto);
                    updateProduct ($connect, $array, $query);
                } 
                else {
                    $_SESSION['msg'] = "Falha ao cadastrar imagem ".$imagem2;
                    header('location:../anuncios.php');
                }   
            }

            if (!$imagem3 == "") {
                if (move_uploaded_file($imagem3Tmp, "../resources/images/products/$imagem3")) {
                    $excluirImagem = $_SESSION['imagem3'];
                    unlink("../resources/images/products/$excluirImagem");
                    $query = "UPDATE imagensprodutos SET imagem3 = ? WHERE idProdutos = ?";
                    $array = array($imagem3, $idproduto);
                    updateProduct ($connect, $array, $query);
                } 
                else {
                    $_SESSION['msg'] = "Falha ao cadastrar imagem ".$imagem3;
                    header('location:../anuncios.php');
                }   
            }

            if (!$imagem4 == "") {
                if (move_uploaded_file($imagem4Tmp, "../resources/images/products/$imagem4")) {
                    $excluirImagem = $_SESSION['imagem4'];
                    unlink("../resources/images/products/$excluirImagem");
                    $query = "UPDATE imagensprodutos SET imagem4 = ? WHERE idProdutos = ?";
                    $array = array($imagem4, $idproduto);
                    updateProduct ($connect, $array, $query);
                } 
                else {
                    $_SESSION['msg'] = "Falha ao cadastrar imagem ".$imagem4;
                    header('location:../anuncios.php');
                }   
            }

            $_SESSION['msg'] = "Produto editado com sucesso";
            header('location:../anuncios.php');
        }
        else {
            $_SESSION['msg'] = "Falha ao editar produto";
            header('location:../editarProduto.php');
        }   
    }

    
    if (isset($_GET['deletarProduto'])) {
        $idproduto = $_GET['deletarProduto'];
        $query = "SELECT * FROM imagensprodutos WHERE idProdutos = ?";
        $array = array($idproduto);
        $imagens = selectProduct ($connect, $array, $query);

        $query = "DELETE FROM imagensprodutos WHERE idProdutos = ?";
        updateProduct ($connect, $array, $query);

        $query = "DELETE FROM produtos WHERE idProdutos = ?";
        updateProduct ($connect, $array, $query);

        $imagem1 = $imagens['imagem1'];
        $imagem2 = $imagens['imagem2'];
        $imagem3 = $imagens['imagem3'];
        $imagem4 = $imagens['imagem4'];
        
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

        $_SESSION['msg'] = "Produto excluido com sucesso";
        header('location:../anuncios.php');
    }

    if(isset($_POST['buscar'])) {
        $busca = $_POST['busca'];
        header("location:../index.php?busca=$busca");
    }
?>