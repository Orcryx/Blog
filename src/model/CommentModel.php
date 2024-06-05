<?php

namespace App\model;

class Comment {
    public int $postId;
    public string $title;
    public string $message;
    public int $userId;
    public string $createAt;
}