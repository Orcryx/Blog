<?php
namespace App\controller;
use App\service\TwigService;

class ContactController
{

    //constructeur de la class 
    public function __construct(private readonly TwigService $twigService)
    {
     
    }
    
    public function getForm()
    {
        return $this->twigService->render('contact_include.twig');
    }

    public function sendEmail(string $email, string $message)
    {
            if (!empty($email) && !empty($message)) {

                // Valider l'email
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    // Préparer les détails de l'email
                    $to = "votre_email@domaine.com"; // Remplacez par votre adresse email
                    $subject = "Nouveau message de contact";
                    $body = "Email: $email\n\nMessage:\n$message";
                    $headers = "From: $email\r\n";
                    $headers .= "Reply-To: $email\r\n";

                    // Envoyer l'email
                    if (mail($to, $subject, $body, $headers)) {
                        echo "Merci, votre message a bien été envoyé.";
                    } else {
                        echo "Désolé, une erreur s'est produite. Veuillez réessayer.";
                    }

                } else {
                    echo "Veuillez fournir une adresse e-mail valide.";
                }

            } else {
                echo "Tous les champs sont requis.";
            }
    }
}
