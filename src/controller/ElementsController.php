<?php

namespace App\controller;

use App\service\TwigService;
// use App\manager\UserManager;

class ElementsController extends AbstractController
{
    // private UserManager $userManager;
    public function __construct(TwigService $twigService)
    {
        //indiquer comment est construite le constructeur de la class Parent
        parent::__construct($twigService);
        // $this->userManager = new UserManager();
    }

    public function showLoginDialogue(string $previous_url)
    {
        $this->renderTemplate('formConnexion.twig', ["origin" => $previous_url]);
    }

    public function showDynamicDialog()
    {
        $currentUrl = $this->getUrl(); // Récupérer l'URL actuelle via getUrl()
        $params = [
            'origine' =>  $currentUrl ?? '',
            'type' => isset($_POST['type']) ? $_POST['type'] : null,
            'postId' => isset($_POST['postId']) ? $_POST['postId'] : null,
            'userId' => isset($_POST['userId']) ? $_POST['userId'] : null,
            'commentId' => isset($_POST['commentId']) ? $_POST['commentId'] : null,
            'comment' => isset($_POST['content']) ? $_POST['content'] : null,
            'title' => isset($_POST['title']) ? $_POST['title'] : null
        ];
        $this->renderTemplate('forms.twig', $params);
    }

    public function showDialog(string $message, ?string $origin = null)
    {
        $currentUrl = $this->getUrl();
        $escapedMessage = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
        if ($origin !== null) {
            $escapedOrigin = htmlspecialchars($origin, ENT_QUOTES, 'UTF-8');
        } else {
            $environment = $currentUrl;
            $escapedOrigin = $environment !== null ? htmlspecialchars($environment, ENT_QUOTES, 'UTF-8') : '';
        }
        $this->renderTemplate('message.twig', [
            'message' => $escapedMessage,
            'origin' => $escapedOrigin
        ]);
    }

    public function showIndex()
    {
        $this->renderTemplate('index.twig', []);
    }

    public function showPage404()
    {
        http_response_code(404);
        $this->renderTemplate('404.twig', []);
    }

    public function showFormContact()
    {
        $this->renderTemplate('contact_include.twig', []);
    }

    public function getUrl()
    {
        $previousUrl = $_SERVER['HTTP_REFERER'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $previousUrl = $_POST['current_url'] ?? $_SESSION['last_url'] ?? $previousUrl;
            $_SESSION['last_url'] = $previousUrl;
        }
        return $previousUrl;
    }
}
