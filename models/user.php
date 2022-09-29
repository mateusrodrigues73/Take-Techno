<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    require_once "C:/xampp/htdocs/my-project/includes/PHPMailer/src/PHPMailer.php";
    require_once "C:/xampp/htdocs/my-project/includes/PHPMailer/src/SMTP.php";

    function  selectUser ($connect, $array, $query) {
        try {
            $query = $connect->prepare($query);
            if ($query->execute($array)) {
                $usuario = $query->fetch();
                if ($usuario) {
                    return $usuario;
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

    function insertUser ($conexao, $array, $query) {
        try {
            $query = $conexao->prepare($query);
            $retorno = $query->execute($array);
            return $retorno;
        }
        catch (PDOException $e) {
            echo 'ERROR'. $e->getMessage();
        }
    }

    function updateUser ($conexao, $array, $query) {
        try {
            $query = $conexao->prepare($query);
            $resultado = $query->execute($array);
            return $resultado;
        }
        catch (PDOException $e) {
            echo 'ERROR'. $e->getMessage();
        }
    }

    function sendEmail ($email, $mensagem, $assunto, $email_resposta=null) {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ]
        ];
        $mail->Username = 'dawexemplo2014@gmail.com'; 
        $mail->Password = 'tcycdlrjmtbngpie';
        $mail->setFrom('exemplo2014@gmail.com','Adm Site');
        $mail->addAddress($email);
        $mail->CharSet = "utf-8";
        if($email_resposta) {
	        $mail->addReplyTo($email_resposta);
        }
        $mail->Subject = $assunto;
        $mail->Body = $mensagem;
        $mail->isHTML(true);
        if (!$mail->send()) {
            return false;
        }
        else {
            return true;
        }
    }

?>