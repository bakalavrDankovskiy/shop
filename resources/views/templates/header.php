<?php

use App\Enums\Roles;

?>
<body>
<header class="page-header">
    <a class="page-header__logo" href="/">
        <img src="../../../public/img/logo.svg" alt="Fashion">
    </a>
    <nav class="page-header__menu">
        <ul class="main-menu main-menu--header">
            <li>
                <a class="main-menu__item" href="/">Главная</a>
            </li>
            <li>
                <a class="main-menu__item" href="/?categories=new">Новинки</a>
            </li>
            <li>
                <a class="main-menu__item active" href="/?categories=sale">Sale</a>
            </li>
            <li>
                <a class="main-menu__item" href="/delivery">Доставка</a>
            </li>
            <li class="dropdown">
                <a style="color:black;text-decoration: none" href="#" class="dropdown-toggle" data-toggle="dropdown"
                   role="button" aria-haspopup="true"
                   aria-expanded="false"><?= $_SESSION['usersRole'] ?? Roles::GUEST ?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <?= isset($_SESSION['is_auth']) ? '<li><a href="/logout">Выйти</a></li>' : '<li><a href="/auth">Войти</a></li>' ?>

                    <?= isset($_SESSION['is_auth']) ? '' : '<li><a href="/signup">Регистрация</a></li>' ?>

                    <?php if (isset($_SESSION['is_auth'])) {

                        if ($_SESSION['usersRole'] == Roles::ADMIN) { ?>
                            <li><a href="/admin/products">Товары</a></li>
                        <?php }

                        if ($_SESSION['usersRole'] == Roles::ADMIN || $_SESSION['usersRole'] == Roles::OPERATOR) { ?>
                            <li><a href="/orders">Заказы</a></li>
                        <?php }
                    } else echo '';
                    ?>
                </ul>
            </li>
        </ul>
    </nav>
</header>

