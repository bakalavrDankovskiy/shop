<main class="page-add">
    <h1 class="h h--1">Добавление товара</h1>
    <form class="custom-form" id="productForm" enctype="multipart/form-data" method="POST" action="/admin/products">
        <?php flash('addProduct') ?>
        <br>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
            <label for="title" class="custom-form__input-wrapper page-add__first-wrapper">
                <input type="text" class="custom-form__input" name="title" id="title" required>
                <p class="custom-form__input-label">
                    Название товара
                </p>
            </label>
            <label for="price" class="custom-form__input-wrapper">
                <input type="text" class="custom-form__input" name="price" id="price" required>
                <p class="custom-form__input-label">
                    Цена товара
                </p>
            </label>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
            <ul class="add-list">
                <li class="add-list__item add-list__item--add">
                    <input type="file" accept="image/jpeg,image/png,image/jpg" name="product-photo" id="product-photo"
                           hidden="">
                    <label for="product-photo">Добавить фотографию</label>
                </li>
            </ul>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Категории</legend>
            <div class="page-add__select">
                <input name="categories[]" value="men" type="checkbox" id="men" class="custom-form__checkbox">
                <label for="men" class="custom-form__checkbox-label">Мужчины</label>
                <input name="categories[]" value="women" type="checkbox" id="women" class="custom-form__checkbox">
                <label for="women" class="custom-form__checkbox-label">Женщины</label>
                <input name="categories[]" value="kids" type="checkbox" id="kids" class="custom-form__checkbox">
                <label for="kids" class="custom-form__checkbox-label">Дети</label>
                <input name="categories[]" value="accessories" type="checkbox" id="accessories"
                       class="custom-form__checkbox">
                <label for="accessories" class="custom-form__checkbox-label">Аксессуары</label>
                <input name="categories[]" value="new" type="checkbox" id="new" class="custom-form__checkbox">
                <label for="new" class="custom-form__checkbox-label">Новинка</label>
                <input name="categories[]" value="sale" type="checkbox" id="sale" class="custom-form__checkbox">
                <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
            </div>
        </fieldset>
        <button class="button" type="submit">Добавить товар</button>
    </form>
</main>