<?php
namespace App\controller;
use App\service\TwigService;
use App\manager\CommentManager;

class CommentController
{
    private CommentManager $commentManager;
    private TwigService $twigService;

    public function __construct(CommentManager $commentManager, TwigService $twigService)
    {
        $this->commentManager = $commentManager;
        $this->twigService = $twigService;
    }

    public function addComment(int $postId, string $comment, int $userId, bool $isValidated): void
    {
       $this->commentManager->addCommentByPostId($postId, $comment, $userId, $isValidated);
        // return $this->twigService->render('message.twig', ['message' => $newComment]);
    }

    public function deleteComment(int $commentId) : void
    {
         $this->commentManager->deleteCommentById($commentId);
        // return $this->twigService->render('message.twig', ['message' => $deleteComment]);
    }

    public function updateComment(int $commentId, string $comment) : void
    {
       $this->commentManager->updateCommentById($commentId, $comment);
        // return $this->twigService->render('message.twig', ['message' => $updateComment]);
    }

    public function publishComment(int $commentId) : void //string si message
    {
         $this->commentManager->publishCommentById($commentId);
        // return $this->twigService->render('message.twig', ['message' => $publishComment]);
    }
}