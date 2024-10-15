<?php

namespace App\controller;

use App\service\TwigService;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\service\UserService;

class ContactController
{
    private UserService $userService;
    private readonly string $mail_pass;
    private readonly string $mail_user;
    private readonly string $mail_host;
    private readonly string $mail_address;

    public function __construct(private readonly TwigService $twigService)
    {
        $this->userService = new UserService();
        //variable d'environnement
        $this->mail_pass = $_ENV["MAIL_PASS"];
        $this->mail_user = $_ENV["MAIL_USER"];
        $this->mail_host = $_ENV["MAIL_HOST"];
        $this->mail_address = $_ENV["MAIL_ADRESS"];
    }

    // Méthode pour afficher le formulaire
    public function getForm()
    {
        return $this->twigService->render('contact_include.twig');
    }

    public function sendEmail(string $email, string $message)
    {
        $environnement = "/";
        if (!empty($email) && !empty($message)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $mail = new PHPMailer();
                try {
                    // Configuration du serveur SMTP
                    $mail->isSMTP();
                    $mail->Host = $this->mail_host;
                    $mail->SMTPAuth = true;
                    $mail->Username = $this->mail_user;
                    $mail->Password = $this->mail_pass;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Destinataire et expéditeur
                    $mail->setFrom($email);
                    $mail->addAddress($this->mail_address);

                    // Contenu de l'email
                    $mail->isHTML(false);
                    $mail->Subject = 'Message du projet Blog';
                    $mail->Body = "Email: $email\n\nMessage:\n$message";

                    // Envoyer l'email
                    $mail->send();
                    $message =  'Merci, votre message a bien été envoyé.';
                } catch (Exception $e) {
                    $message = "Erreur lors de l'envoi du message. Erreur PHPMailer: {$mail->ErrorInfo}";
                }
            } else {
                $message = "Veuillez entrer une adresse email valide.";
            }
        } else {
            $message = "Tous les champs sont requis.";
        }
        // Renvoyer le message avec Twig
        echo $this->twigService->render('message.twig', ['message' => $message, 'origin' => $environnement]);
    }
}
