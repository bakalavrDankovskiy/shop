<?php

namespace App;

use App\Models\User;
use App\View\Renderable;
use App\Exception\HttpException;

class Application
{
    protected Router $router;

    protected User $user;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->initialize();
    }

    public function run()
    {
        try {
            $result = $this->router->dispatch();
            if ($result instanceof Renderable) {
                $result->render();
            } else {
                echo $result;
            }
        } catch (HttpException $e) {
            $this->renderException($e);
        }
    }

    private function initialize()
    {
    }

    private function renderException(HttpException $e)
    {
        if ($e instanceof Renderable) {
            $e->render();
        } else {
            echo '<pre>';
            echo 'Код ошибки ' . $e->getCode() ?? 500;
            echo 'Текст ошибки ' . $e->getMessage();
            echo '</pre>';
        }
    }
}