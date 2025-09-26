<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php'; // Autoload Composer

/**
 * Envoie un mail via PHPMailer et AlwaysData
 * 
 * @param string $to Destinataire
 * @param string $subject Sujet
 * @param string $bodyHtml Contenu HTML
 * @param string $bodyAlt Contenu texte alternatif
 * @param bool $debug Active le debug SMTP (false par défaut)
 * @return true|string True si envoyé, message d'erreur sinon
 */
function sendMail($to, $subject, $bodyHtml, $bodyAlt = '', $debug = false) {
    $mail = new PHPMailer(true);

    try {
        // Configuration SMTP AlwaysData
        $mail->isSMTP();
        $mail->Host       = 'smtp-joagand.alwaysdata.net';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'joagand@alwaysdata.net';
        $mail->Password   = '2107LuluOm!!';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Debug SMTP activable
        if ($debug) {
            $mail->SMTPDebug = 2;
            $mail->Debugoutput = 'html';
        }

        // Expéditeur
        $mail->setFrom('joagand@alwaysdata.net', 'CommuOM');
        $mail->addReplyTo('joagand@alwaysdata.net', 'Support CommuOM');

        // Destinataire
        $mail->addAddress($to);

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $bodyHtml;
        $mail->AltBody = $bodyAlt ?: strip_tags($bodyHtml);

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Erreur SMTP : {$mail->ErrorInfo}";
    }
}
