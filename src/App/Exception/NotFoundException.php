<?php

namespace App\Exception;

use App\View\Renderable;
use App\View\View;

class NotFoundException extends HttpException implements Renderable
{
    protected $message = 'Запрошенному url не соответствует ни один установленный маршрут (Route)';

    public function render()
    {
        $notFoundView = new View('notFound', ['message' => $this->message,]);
        $notFoundView->render();
    }
}