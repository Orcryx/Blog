<?php
declare(strict_types=1);

namespace App\Service;

use App\Service\TwigService;

class MessageService
{

    const ALERT_INFO = "info";
    const ALERT_SUCCESS = "success";
    const ALERT_WARNING = "warning";
    

    public function __construct(private readonly TwigService $twigService) {}

    /**
     * Retourne un message d'alerte ou une chaîne vide
     * @param string|null $message
     * @param string|null $alertType
     * @param TwigService $twigService
     * @return string
     */
    public static function getMessage(string $message, string $alertType, TwigService $twigService): string
    {
        if ($message !== null) {
            $renderedMessage = $twigService->render('message.twig', ["message" => $message, "altertType" => $alertType]);
            
            // Si render retourne null, on retourne une chaîne vide
            return $renderedMessage ?? '';
        }

        return '';
    }
}