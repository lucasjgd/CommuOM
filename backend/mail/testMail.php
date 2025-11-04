<?php
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Vérification que PHPMailer est bien chargé
if (!class_exists(PHPMailer::class)) {
    die("❌ PHPMailer n'est pas chargé !");
} else {
    echo "✅ PHPMailer est chargé.<br>";
}

$mail = new PHPMailer(true);

try {
    // Config serveur SMTP AlwaysData
    $mail->isSMTP();
    $mail->SMTPDebug = 2; // niveau de debug (0 = désactivé, 2 = infos SMTP)
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp-joagand.alwaysdata.net'; // ton SMTP AlwaysData
    $mail->SMTPAuth = true;
    $mail->Username = 'joagand@alwaysdata.net';
    $mail->Password = '2107LuluOm!!';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL
    $mail->Port = 465;


    // Expéditeur
    $mail->setFrom('joagand@alwaysdata.net', 'CommuOM');
    $mail->addReplyTo('joagand@alwaysdata.net', 'Support CommuOM');

    // Destinataire (ton adresse perso pour tester)
    $mail->addAddress('jogandlucas22@gmail.com', 'Lucas');

    // Contenu
    $mail->isHTML(true);
    $mail->Subject = '🚀 Test PHPMailer + AlwaysData';
    $mail->Body = '<h1>Bravo 🎉</h1><p>Ton mail avec PHPMailer et AlwaysData fonctionne !</p>';
    $mail->AltBody = 'Bravo ! Ton mail avec PHPMailer et AlwaysData fonctionne !';

    $mail->send();
    echo "<br>✅ Mail envoyé avec succès à ton adresse de test !";
} catch (Exception $e) {
    echo "<br>❌ Erreur lors de l'envoi : {$mail->ErrorInfo}";
}
