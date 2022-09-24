<?php 

    function insertProduct ($conexao, $array, $query) {
        try {
            $query = $conexao->prepare($query);
            $retorno = $query->execute($array);
            return $retorno;
        }
        catch (PDOException $e) {
            echo 'ERROR'. $e->getMessage();
        }
    }

    function  selectProduct ($connect, $array, $query) {
        try {
            $query = $connect->prepare($query);
            if ($query->execute($array)) {
                $produto = $query->fetch();
                if ($produto) {
                    return $produto;
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        }
        catch (PDOException $e) {
            echo 'ERROR'.$e->getMessage();
        }
    }

    function  selectProducts ($connect, $array, $query) {
        try {
            $query = $connect->prepare($query);
            if ($query->execute($array)) {
                $produto = $query->fetchAll();
                if ($produto) {
                    return $produto;
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        }
        catch (PDOException $e) {
            echo 'ERROR'.$e->getMessage();
        }
    }

    function updateProduct ($connect, $array, $query) {
        try {
            $query = $connect->prepare($query);
            $resultado = $query->execute($array);
            return $resultado;
        }
        catch (PDOException $e) {
            echo 'ERROR'. $e->getMessage();
        }
    }

?>