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

    public function addComment(int $postId, string $comment, int $userId, bool $isValidated): string
    {
        $newComment = $this->commentManager->addCommentByPostId($postId, $comment, $userId, $isValidated);
        return $this->twigService->render('message.twig', ['message' => $newComment]);
    }

    public function deleteComment(int $commentId) : string
    {
        $deleteComment = $this->commentManager->deleteCommentById($commentId);
        return $this->twigService->render('message.twig', ['message' => $deleteComment]);
    }

}