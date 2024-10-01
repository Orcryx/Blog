<?php
namespace App\controller;

use App\service\TwigService;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class ContactController
{
    public function __construct(private readonly TwigService $twigService)
    {
    }

    // Méthode pour afficher le formulaire
    public function getForm()
    {
        return $this->twigService->render('contact_include.twig');
    }

    public function sendEmail(string $email, string $message)
    {
        if (!empty($email) && !empty($message)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $mail = new PHPMailer();
                //$mail->SMTPDebug = 3; // Active le débogage 
           

                try {
                    // Configuration du serveur SMTP
                    $mail->isSMTP();
                    $mail->Host = 'sandbox.smtp.mailtrap.io';
                    $mail->SMTPAuth = true;
                    $mail->Username = '08883ea9ebf495';  
                    $mail->Password = '5713b06b0eed8c';  //mot de passe d'application
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
                    $mail->Port = 587;

                    // Destinataire et expéditeur
                    $mail->setFrom($email);
                    $mail->addAddress('lauryanndev@gmail.com');  // Votre adresse de réception

                    // Contenu de l'email
                    $mail->isHTML(false);  // Envoyer en texte brut
                    $mail->Subject = 'Nouveau message de contact du projet Blog';
                    $mail->Body = "Email: $email\n\nMessage:\n$message";

                    // Envoyer l'email
                    $mail->send();
                    echo 'Merci, votre message a bien été envoyé.';
                } catch (Exception $e) {
                    echo "Erreur lors de l'envoi du message. Erreur PHPMailer: {$mail->ErrorInfo}";
                }
            } else {
                echo "Veuillez entrer une adresse email valide.";
            }
        } else {
            echo "Tous les champs sont requis.";
        }
    }
}


