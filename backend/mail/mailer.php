<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php'; // Autoload Composer / Charger automatiquement les classes avec Composer

/**
 * Send an email using PHPMailer via AlwaysData SMTP
 * / Envoie un mail via PHPMailer et AlwaysData
 *
 * @param string $to Recipient / Destinataire
 * @param string $subject Subject / Sujet
 * @param string $bodyHtml HTML content / Contenu HTML
 * @param string $bodyAlt Alternative text content / Contenu texte alternatif
 * @param bool $debug Enable SMTP debug (default false) / Active le debug SMTP (false par défaut)
 * @return true|string True if sent, error message otherwise / True si envoyé, message d'erreur sinon
 */
function sendMail($to, $subject, $bodyHtml, $bodyAlt = '', $debug = false) {
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration for AlwaysData / Configuration SMTP AlwaysData
        $mail->isSMTP();
        $mail->Host       = 'smtp-joagand.alwaysdata.net';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'joagand@alwaysdata.net';
        $mail->Password   = '2107LuluOm!!';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Enable SMTP debug if requested / Debug SMTP activable
        if ($debug) {
            $mail->SMTPDebug = 2;
            $mail->Debugoutput = 'html';
        }

        // Sender information / Expéditeur
        $mail->setFrom('joagand@alwaysdata.net', 'CommuOM');
        $mail->addReplyTo('joagand@alwaysdata.net', 'Support CommuOM');

        // Recipient / Destinataire
        $mail->addAddress($to);

        // Email content / Contenu
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $bodyHtml;
        $mail->AltBody = $bodyAlt ?: strip_tags($bodyHtml);

        $mail->send();
        return true; // Email sent successfully / Mail envoyé avec succès
    } catch (Exception $e) {
        return "Erreur SMTP : {$mail->ErrorInfo}"; // Return error message / Retourner le message d'erreur
    }
}
