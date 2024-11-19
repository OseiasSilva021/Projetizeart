<?php
require 'conexao.php';
require 'vendor/autoload.php'; // Carrega o PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT INTO emails (email) VALUES (?)");
        $stmt->bind_param('s', $email);

        if ($stmt->execute()) {
            echo "Email cadastrado com sucesso!";
            enviarEmail($email); // Envia email
        } else {
            echo "Erro ao cadastrar email: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Email inválido!";
    }
}

// Função para envio de email com PHPMailer
function enviarEmail($email) {
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'soseias894@gmail.com'; // Seu email
        $mail->Password = 'cqnp pgrw haud kwml';     // Senha de app do Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuração do remetente e destinatário
        $mail->setFrom('soseias894@gmail.com', 'Oseias'); // Remetente
        $mail->addAddress($email);                      // Destinatário

        // Conteúdo do email
        $mail->isHTML(true);
        $mail->Subject = 'Confirmação de Cadastro';
        $mail->Body = '<h1>Obrigado por se cadastrar!</h1><p>Estamos felizes em tê-lo conosco.</p>';
        $mail->AltBody = 'Obrigado por se cadastrar! Estamos felizes em tê-lo conosco.';

        $mail->send();
        echo "Email enviado com sucesso!";
    } catch (Exception $e) {
        echo "Erro ao enviar email: {$mail->ErrorInfo}";
    }
}
?>
