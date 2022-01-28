<?php
header('Content-Type: application/json; charset=utf-8');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
date_default_timezone_set('America/Sao_Paulo');

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$username = '';
$password = '';

try {
    if((isset($_POST['type']) && $_POST['type'] == "MESSAGE" )){
        if ((isset($_POST['email']) && $_POST['email'] != "" ) && (isset($_POST['name'])  && $_POST['name'] != "") && (isset($_POST['message'])  && $_POST['message'] != "")) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];
            $phone = $_POST['phone'] ?? null;
        
            $mail = new PHPMailer();
            // $mail->SMTPDebug = SMTP::DEBUG_CONNECTION;
            $mail->SMTPDebug = false;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $username;
            $mail->Password = $password;
            $mail->Port = 587;
        
            $mail->setFrom($username);
            $mail->addAddress($username);
        
            $mail->isHTML(true);
            $mail->Subject = 'Mensagem do site';
            $mail->Body = "Nome: {$name}<br>
                           Email: {$email}<br><br>
                           Telefone: {$phone}<br>
                           Mensagem: {$message}";
        
            $_SESSION['erro'] = "";
        
            if ($mail->send()) {
                $data = ['status' => true, 'message' => 'Email enviado com sucesso'];
            } else {
                $data = ['status' => false, 'message' => 'Error na função do envio'];
            }
        } else {
            $data = ['status' => false, 'message' => 'Informe o nome, email e a messagem'];
        }
    }else if((isset($_POST['type']) && $_POST['type'] == "MARKETING" )) {
        if ((isset($_POST['email']) && $_POST['email'] != "" )) {

            $email = $_POST['email'];
        
            $mail = new PHPMailer();
            // $mail->SMTPDebug = SMTP::DEBUG_CONNECTION;
            $mail->SMTPDebug = false;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $username;
            $mail->Password = $password;
            $mail->Port = 587;
        
            $mail->setFrom($username);
            $mail->addAddress($username);
            $mail->Subject = 'Cliente que deseja receber novidades';

            $mail->isHTML(true);
            $mail->Body = "Email: {$email}<br>
                            Deseja receber novidades e promoções exclusivas da My Club Academia";
        
            $_SESSION['erro'] = "";
        
            if ($mail->send()) {
                $data = ['status' => true, 'message' => 'Email enviado com sucesso'];
            } else {
                $data = ['status' => false, 'message' => 'Error na função do envio'];
            }
        } else {
            $data = ['status' => false, 'message' => 'Informe o nome, email e a messagem'];
        }
    }else{
        $data = ['status' => false, 'message' => 'Tipo informado é inválido'];
    }
    
} catch (\Exception $e) {
    $data = ['status' => false, 'message' => 'Error ao enviar email'.$e->getMessage()];
}
echo json_encode($data);