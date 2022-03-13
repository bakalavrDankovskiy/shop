<?php

use App\Controllers\OrderController;
use App\Controllers\UserController;
use App\Route;
use App\Controllers\ProductController;
use App\View\View;
use App\Enums\Roles;

return [
    /**
     * USER
     */
    //Главная страница
    new Route(
        'GET',
        '/^\/(\?.*?)?$/',
        function () {
            return new View('main');
        },
    ),

    new Route(
        'GET',
        '/^\/products(\?.*?)?$/',
        ProductController::class . '@get',
    ),

    //раздел о доставке
    new Route(
        'GET',
        '/^\/delivery$/',
        function () {
            return new View('delivery');
        }
    ),

    //страница авторизации
    new Route(
        'GET',
        '/^\/auth$/',
        function () {
            return new View('auth');
        }
    ),

    //страница регистрации
    new Route(
        'GET',
        '/^\/signup$/',
        function () {
            return new View('signup');
        }
    ),

    //страница сброса текущей сессии
    new Route(
        'GET',
        '/^\/logout$/',
        UserController::class . '@logout'
    ),

    //Регистрация пользователя
    new Route(
        'POST',
        '/^\/signup$/',
        UserController::class . '@register'
    ),

    //Авторизация пользователя
    new Route(
        'POST',
        '/^\/auth$/',
        UserController::class . '@login'
    ),

    //Добавление товара в список заказов
    new Route(
        'POST',
        '/^\/orders$/',
        OrderController::class . '@save'
    ),

    /**
     * OPERATOR
     */
    (new Route(
        'GET',
        '/^\/orders$/',
        function () {
            return new View('orders');
        },
    ))->setGate(Roles::OPERATOR),

    (new Route(
        'GET',
        '/^\/getorders$/',
        OrderController::class . '@get',
    ))->setGate(Roles::OPERATOR),

    (new Route(
        'POST',
        '/^\/orders\/changeStatus$/',
        OrderController::class . '@changeStatus',
    ))->setGate(Roles::OPERATOR),

    /**
     * ADMIN
     */
    (new Route(
        'GET',
        '/^\/admin\/products$/',
        function () {
            return new View('products');
        },
    ))->setGate(Roles::ADMIN),

    (new Route(
        'GET',
        '/^\/admin\/products\/add$/',
        function () {
            return new View('add');
        },
    ))->setGate(Roles::ADMIN),

    (new Route(
        'GET',
        '/^\/admin\/products\/edit(\?.*?)?$/',
        ProductController::class . '@findById',
    ))->setGate(Roles::ADMIN),

    (new Route(
        'DELETE',
        '/^\/admin\/products\/delete\?id=\d+$/',
        ProductController::class . '@delete',
    ))->setGate(Roles::ADMIN),

    (new Route(
        'POST',
        '/^\/admin\/products$/',
        ProductController::class . '@save',
    ))->setGate(Roles::ADMIN),

    (new Route(
        'POST',
        '/^\/admin\/products\/edit$/',
        ProductController::class . '@update',
    ))->setGate(Roles::ADMIN),

    (new Route(
        'POST',
        '/^\/admin\/products$/',
        ProductController::class . '@save',
    ))->setGate(Roles::ADMIN),
];