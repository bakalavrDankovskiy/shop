<?php $product = $product ?? null?>
<main class="page-add">
    <h1 class="h h--1">Изменение товара</h1>
    <form id="editProductForm" enctype="multipart/form-data" method="POST" class="custom-form" action="/admin/products/edit">
        <?php flash('editProduct') ?>
        <br>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
            <label for="title" class="custom-form__input-wrapper page-add__first-wrapper">
                Название: <input type="text" class="custom-form__input" name="title" id="title" value="<?=$product->title?>">
            </label>
            <label for="price" class="custom-form__input-wrapper">
                Цена: <input type="text" class="custom-form__input" name="price" id="price" value=<?=$product->price?>>
            </label>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Изменить фото товара</legend>
            <ul class="add-list">
                <li class="add-list__item add-list__item--add">
                    <img src="/public/img/products/<?=$product->pic_source?>" alt="">
                    <br>
                    <br>
                    <input type="file" accept="image/jpeg,image/png,image/jpg" name="product-photo" id="product-photo">
                    </label>
                </li>
            </ul>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Категории</legend>
            <div class="page-add__select">
                <input name="categories[]" value="men" type="checkbox" id="men" class="custom-form__checkbox" <?=str_contains($product->categories, 'men') ? 'checked' : ''?>>
                <label for="men" class="custom-form__checkbox-label">Мужчины</label>
                <input name="categories[]" value="women" type="checkbox" id="women" class="custom-form__checkbox"  <?=str_contains($product->categories, 'women') ? 'checked' : ''?>>
                <label for="women" class="custom-form__checkbox-label">Женщины</label>
                <input name="categories[]" value="kids" type="checkbox" id="kids" class="custom-form__checkbox" <?=str_contains($product->categories, 'kids') ? 'checked' : ''?>>
                <label for="kids" class="custom-form__checkbox-label">Дети</label>
                <input name="categories[]" value="accessories" type="checkbox" id="accessories" class="custom-form__checkbox" <?=str_contains($product->categories, 'accessories') ? 'checked' : ''?>>
                <label for="accessories" class="custom-form__checkbox-label">Аксессуары</label>
                <input name="categories[]" value="new" type="checkbox" id="new" class="custom-form__checkbox" <?=str_contains($product->categories, 'new') ? 'checked' : ''?>>
                <label for="new" class="custom-form__checkbox-label">Новинка</label>
                <input name="categories[]" value="sale" type="checkbox" id="sale" class="custom-form__checkbox" <?=str_contains($product->categories, 'sale') ? 'checked' : ''?>>
                <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
            </div>
        </fieldset>
        <input name="id" value="<?=$_GET['id']?>" type="hidden">
        <button class="button" type="submit">Обновить карту товара</button>
    </form>
</main>
