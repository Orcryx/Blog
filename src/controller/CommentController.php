<?php
// namespace App\controller;
// use App\service\TwigService;
// use App\manager\CommentManager;



// class CommentController
// {
//     private TwigService $twigService;
//     private CommentManager $commentManager;

//     //constructeur de la class 
//     public function __construct(CommentManager $commentManager)
//     {
//         $this->twigService = new TwigService();
//         $this->commentManager = $commentManager;
//     }


// public function dysplayCommentById($id)
//      {
//         $comment =  $this->commentManager->getComment($id);
//         echo $this->twigService->twigEnvironnement->render('test.twig',['comment' => $comment]);
//      }
// }