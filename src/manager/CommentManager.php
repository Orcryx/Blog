<?php

namespace App\manager;

use App\model\CommentModel;
use App\repository\CommentRepository;


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
        $commentModels = CommentModel::createFromEntities($commentEntities);
        return $commentModels;
    }

}