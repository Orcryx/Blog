<?php

namespace App\manager;

use App\model\CommentModel;
use App\repository\CommentRepository;
use App\model\UserSessionModel;

class CommentManager {

    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
        // session_start();
    }

    /** 
     * @return CommentModel[] 
     */
    public function getCommentByPost(int $postId): array {
        $commentEntities = $this->commentRepository->getValidatedCommentByPostId($postId);
        return  $commentEntities;
    }

    public function isOwner(int $commentId, UserSessionModel $userSession): bool {
        $commentEntity = $this->commentRepository->getCommentById($commentId);
        if ($commentEntity) {
            return $userSession->isOwer($commentEntity->userId);
        }
        return false;
    }

    public function addCommentByPostId(int $postId, string $comment, int $userId, int $isValidated): void {
         $this->commentRepository->createCommentByPostId($postId, $comment, $userId, $isValidated);
    }

    public function deleteCommentById(int $commentId) : void
    {
        $this->commentRepository->deleteCommentById($commentId);
    }

     /** 
     * @return CommentModel[] 
     */
    public function getNoValidatedComment(): array {
        $commentNoValidatedEntities = $this->commentRepository->getNoValidatedComment();
        return  CommentModel::createFromEntities($commentNoValidatedEntities);
    }

}