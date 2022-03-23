<?php

namespace App\Exception;

use App\View\Renderable;
use App\View\View;

class NotFoundException extends HttpException implements Renderable
{
    protected $message = 'Страница не найдена';

    public function render()
    {
        $notFoundView = new View('notFound', ['message' => $this->message,]);
        $notFoundView->render();
    }
}