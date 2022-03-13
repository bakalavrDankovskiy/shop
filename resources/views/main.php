<main class="shop-page">
    <header class="intro">
        <div class="intro__wrapper">
            <h1 class=" intro__title">COATS</h1>
            <p class="intro__info">Collection 2018</p>
        </div>
    </header>
    <section class="shop container">
        <section class="shop__filter filter">
            <form id="filter">
                <b class="filter__title">Категории</b>
                <fieldset class="custom-form__group">

                    <input type="checkbox" id="women" class="custom-form__checkbox">
                    <label for="women" class="custom-form__checkbox-label custom-form__info" style="display: block;">Женщины</label>

                    <input type="checkbox" id="men" class="custom-form__checkbox">
                    <label for="men" class="custom-form__checkbox-label custom-form__info" style="display: block;">Мужчины</label>

                    <input type="checkbox" id="kids" class="custom-form__checkbox">
                    <label for="kids" class="custom-form__checkbox-label custom-form__info"
                           style="display: block;">Дети</label>

                    <input type="checkbox" id="accessories" class="custom-form__checkbox">
                    <label for="accessories" class="custom-form__checkbox-label custom-form__info"
                           style="display: block;">Аксессуары</label>

                    <input type="hidden" value="" name="categories" class="category__filter">
                    <input type="hidden" value="" name="sortOption">
                    <input type="hidden" value="" name="sortOrder">
                </fieldset>

                <div class="filter__wrapper">
                    <b class="filter__title">Фильтры</b>
                    <div class="filter__range range">
                        <span class="range__info">Цена</span>
                        <div class="range__line" aria-label="Range Line"></div>
                        <div class="range__res">
                            <span class="range__res-item min-price">200 руб.</span>
                            <span class="range__res-item max-price">32 000 руб.</span>
                            <input type="hidden" value="200" name="minPrice" class="range__res-item min-res">
                            <input type="hidden" value="32000" name="maxPrice" class="range__res-item max-res">
                        </div>
                    </div>
                </div>

                <fieldset class="custom-form__group">
                    <input type="checkbox" id="new" class="custom-form__checkbox">
                    <label for="new" class="custom-form__checkbox-label custom-form__info" style="display: block;">Новинки</label>
                    <input value="0" type="checkbox" id="sale" class="custom-form__checkbox">
                    <label for="sale" class="custom-form__checkbox-label custom-form__info" style="display: block;">Распродажа</label>
                </fieldset>
                <button class="button" type="submit" style="width: 100%">Применить</button>
            </form>
        </section>

        <div class="shop__wrapper">
            <section class="shop__sorting">
                <div class="shop__sorting-item custom-form__select-wrapper">
                    <select class="custom-form__select" name="sortOption" id="sortOption">
                        <option value="price" selected>По цене</option>
                        <option value="title">По названию</option>
                    </select>
                </div>
                <div class="shop__sorting-item custom-form__select-wrapper">
                    <select class="custom-form__select" name="sortOrder" id="sortOrder">
                        <option value="asc" selected>По возрастанию</option>
                        <option value="desc">По убыванию</option>
                    </select>
                </div>
                <p class="shop__sorting-res">Найдено <span class="res-sort">0</span> моделей</p>
            </section>
            <section class="shop__list">
            </section>
        </div>
    </section>
    <section class="shop-page__order" hidden="">
        <div class="shop-page__wrapper">
            <h2 class="h h--1">Оформление заказа</h2>
            <form method="post" class="custom-form js-order" id="js-order">
                <fieldset class="custom-form__group">
                    <legend class="custom-form__title">Укажите свои личные данные</legend>
                    <p class="custom-form__info">
                        <span class="req">*</span> поля обязательные для заполнения
                    </p>
                    <div class="custom-form__column">
                        <label class="custom-form__input-wrapper" for="surname">
                            <input id="surname" class="custom-form__input" type="text" required="">
                            <p class="custom-form__input-label">Фамилия <span class="req">*</span></p>
                        </label>
                        <label class="custom-form__input-wrapper" for="name">
                            <input id="name" class="custom-form__input" type="text" required="">
                            <p class="custom-form__input-label">Имя <span class="req">*</span></p>
                        </label>
                        <label class="custom-form__input-wrapper" for="thirdName">
                            <input id="thirdName" class="custom-form__input" type="text">
                            <p class="custom-form__input-label">Отчество</p>
                        </label>
                        <label class="custom-form__input-wrapper" for="phone">
                            <input id="phone" class="custom-form__input" type="tel" required="">
                            <p class="custom-form__input-label">Телефон <span class="req">* +7|8**********</span></p>
                        </label>
                        <label class="custom-form__input-wrapper" for="email">
                            <input id="email" class="custom-form__input" type="email" required="">
                            <p class="custom-form__input-label">Почта <span class="req">*</span></p>
                        </label>
                    </div>
                </fieldset>
                <fieldset class="custom-form__group js-radio">
                    <legend class="custom-form__title custom-form__title--radio">Способ доставки</legend>
                    <input id="dev-no" class="custom-form__radio" type="radio" name="dev"
                           checked="">
                    <label for="dev-no" class="custom-form__radio-label">Самовывоз</label>
                    <input id="dev-yes" class="custom-form__radio" type="radio" name="dev">
                    <label for="dev-yes" class="custom-form__radio-label">Курьерная доставка</label>
                </fieldset>
                <div class="shop-page__delivery shop-page__delivery--no">
                    <table class="custom-table">
                        <caption class="custom-table__title">Пункт самовывоза</caption>
                        <tr>
                            <td class="custom-table__head">Адрес:</td>
                            <td>Москва г, Тверская ул,<br> 4 Метро «Охотный ряд»</td>
                        </tr>
                        <tr>
                            <td class="custom-table__head">Время работы:</td>
                            <td>пн-вс 09:00-22:00</td>
                        </tr>
                        <tr>
                            <td class="custom-table__head">Оплата:</td>
                            <td>Наличными или банковской картой</td>
                        </tr>
                        <tr>
                            <td class="custom-table__head">Срок доставки:</td>
                            <td class="date">13 декабря—15 декабря</td>
                        </tr>
                    </table>
                </div>
                <div class="shop-page__delivery shop-page__delivery--yes" hidden="">
                    <fieldset class="custom-form__group">
                        <legend class="custom-form__title">Адрес</legend>
                        <p class="custom-form__info">
                            <span class="req">*</span> поля обязательные для заполнения
                        </p>
                        <div class="custom-form__row">
                            <label class="custom-form__input-wrapper" for="city">
                                <input id="city" class="custom-form__input" type="text">
                                <p class="custom-form__input-label">Город <span class="req">*</span></p>
                            </label>
                            <label class="custom-form__input-wrapper" for="street">
                                <input id="street" class="custom-form__input" type="text">
                                <p class="custom-form__input-label">Улица <span class="req">*</span></p>
                            </label>
                            <label class="custom-form__input-wrapper" for="home">
                                <input id="home" class="custom-form__input custom-form__input--small" type="text"
                                >
                                <p class="custom-form__input-label">Дом <span class="req">* </span></p>
                            </label>
                            <label class="custom-form__input-wrapper" for="aprt">
                                <input id="aprt" class="custom-form__input custom-form__input--small" type="text"
                                >
                                <p class="custom-form__input-label">Квартира <span class="req">*</span></p>
                            </label>
                        </div>
                    </fieldset>
                </div>
                <fieldset class="custom-form__group shop-page__pay">
                    <legend class="custom-form__title custom-form__title--radio">Способ оплаты</legend>
                    <input id="cash" class="custom-form__radio" type="radio" name="paymentMethod">
                    <label for="cash" class="custom-form__radio-label">Наличные</label>
                    <input id="card" class="custom-form__radio" type="radio" checked="" name="paymentMethod">
                    <label for="card" class="custom-form__radio-label">Банковской картой</label>
                </fieldset>
                <fieldset class="custom-form__group shop-page__comment">
                    <legend class="custom-form__title custom-form__title--comment">Комментарии к заказу</legend>
                    <textarea class="custom-form__textarea"></textarea>
                </fieldset>
                <button class="button" type="submit">Отправить заказ</button>
            </form>
        </div>
    </section>
    <section class="shop-page__popup-end" hidden="">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
            <h2 class="h h--1 h--icon shop-page__end-title">Спасибо за заказ!</h2>
            <p class="shop-page__end-message">Ваш заказ успешно оформлен, с вами свяжутся в ближайшее время</p>
            <button class="button">Продолжить покупки</button>
        </div>
    </section>
    <!-- Button trigger modal -->
    <button id="modalButton" hidden data-toggle="modal" data-target="#myModal">
    </button>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <p style="color: red">Ошибка: </p>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</main>


