<main class="page-authorization">
    <h1 class="h h--1">Авторизация</h1>
    <form class="custom-form" action="/auth" method="post">

        <?php flash('error') ?>
        <?php flash('success') ?>

        <input name="email" type="email" class="custom-form__input email" placeholder="Email" required="">
        <input name="password" type="password" class="custom-form__input password" placeholder="Password" required="">
        <button class="button" type="submit">Войти в личный кабинет</button>
    </form>
</main>
