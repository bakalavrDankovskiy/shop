<?php

namespace App;

use App\Enums\Roles;

class Route
{
    /**
     * http запрос, для которого подходит маршрут get или post
     */
    private $httpMethod;

    /**
     * uri маршрута
     */
    private $uriPattern;

    /**
     * callback - маршрута
     */
    private $callback;

    /**
     * Определяет gate на маршрут
     */
    private $gate;

    public function __construct($httpMethod, $uriPattern, $callback)
    {
        $this->httpMethod = $httpMethod;
        $this->uriPattern = $uriPattern;
        $this->callback = $callback;
    }

    public function run()
    {
        return call_user_func($this->prepareCallback($this->callback));
    }

    public function match($httpMethod, $uri)
    {
        return $this->httpMethod == $httpMethod && $this->matchUriPattern($uri) && $this->letRunTheRoute();
    }

    public function setGate($gate)
    {
        $this->gate = $gate;
        return $this;
    }

    private function letRunTheRoute()
    {
        if (!empty($this->gate)) {
            if (isset($_SESSION['is_auth'])) {
                return match ($this->gate) {
                    Roles::ADMIN => $_SESSION['usersRole'] == Roles::ADMIN,
                    Roles::OPERATOR => $_SESSION['usersRole'] == Roles::OPERATOR || $_SESSION['usersRole'] == Roles::ADMIN,
                    Roles::USER => $_SESSION['is_auth'],
                };
            } else {
                return $this->gate == Roles::GUEST;
            }
        }
        return true;
    }

    private function prepareCallback($callback)
    {
        if (is_callable($callback)) {
            return $callback;
        } else {
            $controller = explode('@', $callback);
            $controllerClass = $controller[0];
            $controllerMethod = $controller[1];
            return [new $controllerClass(), $controllerMethod];
        }
    }

    private function matchUriPattern($uri): bool
    {
        return (bool)preg_match($this->uriPattern, $uri);
    }
}
