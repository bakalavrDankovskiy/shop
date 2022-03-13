<?php

namespace App;

use App\Exception\NotFoundException;

class Router
{
    /**
     * @var $routes Route[]
     * Таблица маршрутов, key=Route object, value=action
     */
    private $routes = [];

    public function __construct()
    {
        $this->includeRoutes(getRoutes());
    }

    //добавляет маршрут в виде объекта App/Route в таблицу рутов
    public function setNewRoute($method, $path, $action)
    {
        $this->routes[] = new Route($method, $path, $action);
    }

    public function includeRoutes(array $routes)
    {
        $this->routes = $routes;
    }

    public function dispatch()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route->match($requestMethod, $requestUri)) {
                return $route->run();
            }
        }
        throw new NotFoundException();
    }
}