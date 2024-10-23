<?php

namespace App\controller;

use App\service\TwigService;

class AbstractController
{
  public function __construct(private readonly TwigService $twigService) {}

  public function renderTemplate(string $template, array $data): void
  {
    echo $this->twigService->render($template, $data);
  }
}
