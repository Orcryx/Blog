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

}