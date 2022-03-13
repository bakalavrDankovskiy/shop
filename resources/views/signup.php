<main class="page-authorization">
    <h1 class="h h--1">Регистрация</h1>
    <form class="custom-form needs-validation" action="/signup" method="post" >
        <?php flash('register') ?>
        <input name="name" class="custom-form__input name form-control" placeholder="Name" required="">
        <input name="email" type="email" class="custom-form__input email form-control" placeholder="Email" required="">

        <input name="password" type="password" class="custom-form__input password form-control" placeholder="Password" required="">
        <input name="passwordRepeat" type="password" class="custom-form__input password form-control" placeholder="Repeat Password"
               required="">
        <button class="button btn btn-primary" type="submit">Зарегистрироваться</button>
    </form>
</main>