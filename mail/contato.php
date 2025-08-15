<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    if (isset($_POST['nome']) && !empty($_POST['nome'])) {
        $nome = $_POST['nome'];
    }
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = $_POST['email'];
    }
    if (isset($_POST['assunto']) && !empty($_POST['assunto'])) {
        $assunto = $_POST['assunto'];
    }
    if (isset($_POST['mensagem']) && !empty($_POST['mensagem'])) {
        $mensagem = $_POST['mensagem'];
    }
    if(!empty($_POST['emails'])) header("location: error_send.php"); //Prevencao de spam

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';                   //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'contato@analiticasolucoes.com.br';     //SMTP username
        $mail->Password   = 'T!qu!nh0';                             //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->SMTPDebug  = 0;                                      //Habilita Modo de depuracao com 2 ou desabilita com 0.                              

        //Recipients
        $mail->setFrom("contato@analiticasolucoes.com.br", "Formulario de Contato - Analitica Solucoes");
        $mail->addAddress("contato@analiticasolucoes.com.br", "Analitica Solucoes");     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "Solicitacao de Contato via Site - {$nome} / {$assunto}";
        $mail->Body    = "<p>Ola, estive em seu site e gostaria que entrasse em contato comigo!</p><p>Me chamo {$nome}, segue meu e-mail: {$email}. Aguardo seu retorno!</p><p>Mensagem: {$mensagem}</p>";
        $mail->AltBody = "<p>Ola, estive em seu site e gostaria que entrasse em contato comigo!</p><p>Me chamo {$nome}, segue meu e-mail: {$email}. Aguardo seu retorno!</p><p>Mensagem: {$mensagem}</p>";

        $mail->send();
        header("location: sucess_send.php");
    } catch (Exception $e) {
        var_dump($e);
        //header("location: error_send.php");
    }
?>