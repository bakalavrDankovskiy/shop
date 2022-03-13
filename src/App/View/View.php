<?php

namespace App\View;

use App\Exception\NotFoundException;

class View implements Renderable
{
    public $view;
    public $params;

    public function __construct($view, $params = null)
    {
        $this->addFullPathForView($view);
        $this->params = $params;
    }

    public function render()
    {
        if (file_exists($this->view)) {
            $view = $this->view;

            if (!empty($this->params)) {
                extract($this->params);
            }

            require APP_DIR . DS . 'resources' . DS . 'views' . DS . 'app.php';

        } else {
            throw new NotFoundException();
        }
    }

    private function addFullPathForView(string $view)
    {
        $view = APP_DIR . DS . 'resources' . DS . 'views' . DS . str_replace('.', DS, $view) . '.php';
        $this->view = $view;
    }
}