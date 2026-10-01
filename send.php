```php
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Dati ricevuti dal form
$destinatario = $_POST['email'] ?? '';
$messaggio = $_POST['messaggio'] ?? '';

// Controllo email
if (!filter_var($destinatario, FILTER_VALIDATE_EMAIL)) {
    die("Email non valida.");
}

if (empty($messaggio)) {
    die("Il messaggio è obbligatorio.");
}

$mail = new PHPMailer(true);

try {

    // Configurazione SMTP Gmail
    $mail->isSMTP();

    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'tuamail@gmail.com';

    // NON usare la normale password Gmail
    // Usa una "Password per le app"
    $mail->Password   = 'LA_TUA_PASSWORD_PER_APP';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Mittente
    $mail->setFrom(
        'tuamail@gmail.com',
        'Il mio sito'
    );

    // Destinatario
    $mail->addAddress($destinatario);

    // Contenuto
    $mail->isHTML(true);

    $mail->Subject = 'Messaggio dal mio sito';

    $mail->Body = '
        <h2>Nuovo messaggio</h2>

        <p>' . nl2br(htmlspecialchars($messaggio)) . '</p>

        <hr>

        <p>
            Email inviata automaticamente dal sito.
        </p>
    ';

    // Invia
    $mail->send();

    echo "Email inviata correttamente!";

} catch (Exception $e) {

    echo "Errore durante l'invio: " . $mail->ErrorInfo;
}
```
