'use strict';

const toggleHidden = (...fields) => {

    fields.forEach((field) => {

        if (field.hidden === true) {

            field.hidden = false;

        } else {

            field.hidden = true;

        }
    });
};

const labelHidden = (form) => {

    form.addEventListener('focusout', (evt) => {

        const field = evt.target;
        const label = field.nextElementSibling;

        if (field.tagName === 'INPUT' && field.value && label) {

            label.hidden = true;

        } else if (label) {

            label.hidden = false;

        }
    });
};

const toggleDelivery = (elem) => {

    const delivery = elem.querySelector('.js-radio');
    const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
    const deliveryNo = elem.querySelector('.shop-page__delivery--no');
    const fields = deliveryYes.querySelectorAll('.custom-form__input');

    delivery.addEventListener('change', (evt) => {

        if (evt.target.id === 'dev-no') {

            fields.forEach(inp => {
                if (inp.required === true) {
                    inp.required = false;
                }
            });

            toggleHidden(deliveryYes, deliveryNo);

            deliveryNo.classList.add('fade');
            setTimeout(() => {
                deliveryNo.classList.remove('fade');
            }, 1000);

        } else {

            fields.forEach(inp => {
                if (inp.required === false) {
                    inp.required = true;
                }
            });

            toggleHidden(deliveryYes, deliveryNo);

            deliveryYes.classList.add('fade');
            setTimeout(() => {
                deliveryYes.classList.remove('fade');
            }, 1000);
        }
    });
};

const filterWrapper = document.querySelector('.filter__list');
if (filterWrapper) {

    filterWrapper.addEventListener('click', evt => {

        const filterList = filterWrapper.querySelectorAll('.filter__list-item');

        filterList.forEach(filter => {

            if (filter.classList.contains('active')) {

                filter.classList.remove('active');

            }

        });

        const filter = evt.target;

        filter.classList.add('active');

    });

}

const shopList = document.querySelector('.shop__list');
if (shopList) {

    shopList.addEventListener('click', (evt) => {

        const prod = evt.path || (evt.composedPath && evt.composedPath());


        if (prod.some(pathItem => pathItem.classList && pathItem.classList.contains('shop__item'))) {

            const shopOrder = document.querySelector('.shop-page__order');

            toggleHidden(document.querySelector('.intro'), document.querySelector('.shop'), shopOrder);

            window.scroll(0, 0);

            shopOrder.classList.add('fade');
            setTimeout(() => shopOrder.classList.remove('fade'), 1000);

            const form = shopOrder.querySelector('.custom-form');
            labelHidden(form);

            toggleDelivery(shopOrder);

            const buttonOrder = shopOrder.querySelector('.button');
            const popupEnd = document.querySelector('.shop-page__popup-end');
            const popupEndFail = document.querySelector('.shop-page__fail__popup-end');

            buttonOrder.addEventListener('click', async (evt) => {

                form.noValidate = true;

                const inputs = Array.from(shopOrder.querySelectorAll('[required]'));

                inputs.forEach(inp => {

                    if (!!inp.value) {

                        if (inp.classList.contains('custom-form__input--error')) {
                            inp.classList.remove('custom-form__input--error');
                        }

                    } else {

                        inp.classList.add('custom-form__input--error');

                    }
                });

                if (inputs.every(inp => !!inp.value)) {

                    evt.preventDefault();

                    urlParamsObject.product.deliveryInfo.client = {
                        name: document.querySelector('#name').value,
                        surname: document.querySelector('#surname').value,
                        thirdName: document.querySelector('#thirdName').value,
                        phone: document.querySelector('#phone').value,
                        email: document.querySelector('#email').value,
                    };

                    if (document.querySelector('#dev-no').checked === true) {
                        urlParamsObject.product.deliveryInfo.needDelivery = false;
                    }
                    if (document.querySelector('#dev-yes').checked === true) {
                        urlParamsObject.product.deliveryInfo.needDelivery = true;
                        urlParamsObject.product.deliveryInfo.address = {
                            city: document.querySelector('#city').value,
                            street: document.querySelector('#street').value,
                            home: document.querySelector('#home').value,
                            aprt: document.querySelector('#aprt').value,
                        };
                    }
                    if (document.querySelector('#cash').checked === true) {
                        urlParamsObject.product.deliveryInfo.paymentMethod = 'Наличные';
                    }
                    if (document.querySelector('#card').checked === true) {
                        urlParamsObject.product.deliveryInfo.paymentMethod = 'Карта';
                    }

                    urlParamsObject.product.deliveryInfo.comment = document.querySelector('.custom-form__textarea').value;

                    const orderResult = await saveOrder(urlParamsObject.product);

                    if (orderResult.value === 1) {
                        toggleHidden(shopOrder, popupEnd);
                        popupEnd.classList.add('fade');
                        setTimeout(() => popupEnd.classList.remove('fade'), 1000);

                        window.scroll(0, 0);

                        const buttonEnd = popupEnd.querySelector('.button');

                        buttonEnd.addEventListener('click', () => {

                            popupEnd.classList.add('fade-reverse');

                            setTimeout(() => {

                                popupEnd.classList.remove('fade-reverse');

                                toggleHidden(popupEnd, document.querySelector('.intro'), document.querySelector('.shop'));

                            }, 1000);

                        });
                    } else {
                        document.querySelector('.modal-body > p').innerHTML = '';
                        document.querySelector('.modal-body > p').innerHTML = 'Ошибка:' + orderResult.error;
                        document.querySelector('#modalButton').dispatchEvent(new MouseEvent("click", {
                            view: window,
                            bubbles: true,
                            cancelable: true,
                            clientX: 0,
                            clientY: 0,
                            button: 0
                        }));
                    }

                } else {
                    window.scroll(0, 0);
                    evt.preventDefault();
                }
            });
        }
    });
}

async function saveOrder(order) { // <- product object

    const response = await fetch(location.origin + '/orders', {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",  // sent request
            "Accept": "application/json"   // expected data sent back
        },
        body: JSON.stringify(order),
    });
    if (response.ok) {
        const result = await response.json();
        return await result;
    } else {
        alert("Ошибка HTTP: " + response.status);
        return false;
    }
}

const pageOrderList = document.querySelector('.page-order__list');
if (pageOrderList) {

    pageOrderList.addEventListener('click', evt => {


        if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
            var path = evt.path || (evt.composedPath && evt.composedPath());
            Array.from(path).forEach(element => {

                if (element.classList && element.classList.contains('page-order__item')) {

                    element.classList.toggle('order-item--active');

                }

            });

            evt.target.classList.toggle('order-item__toggle--active');

        }

        if (evt.target.classList && evt.target.classList.contains('order-item__btn')) {

            const status = evt.target.previousElementSibling;

            if (status.classList && status.classList.contains('order-item__info--no')) {
                status.textContent = 'Выполнено';
            } else {
                status.textContent = 'Не выполнено';
            }

            status.classList.toggle('order-item__info--no');
            status.classList.toggle('order-item__info--yes');

        }

    });

}

const checkList = (list, btn) => {

    if (list.children.length === 1) {

        btn.hidden = false;

    } else {
        btn.hidden = true;
    }

};
const addList = document.querySelector('.add-list');

if (addList) {

    const form = document.querySelector('.custom-form');
    labelHidden(form);

    const addButton = addList.querySelector('.add-list__item--add');
    const addInput = addList.querySelector('#product-photo');

    checkList(addList, addButton);

    addInput.addEventListener('change', evt => {

        const template = document.createElement('LI');
        const img = document.createElement('IMG');

        template.className = 'add-list__item add-list__item--active';
        template.addEventListener('click', evt => {
            addList.removeChild(evt.target);
            addInput.value = '';
            checkList(addList, addButton);
        });

        const file = evt.target.files[0];
        const reader = new FileReader();

        reader.onload = (evt) => {
            img.src = evt.target.result;
            template.appendChild(img);
            addList.appendChild(template);
            checkList(addList, addButton);
        };

        reader.readAsDataURL(file);

    });
}

$(async function () {

    initParamsObject();

    if (document.querySelector('.shop-page')) {
        const products = await fetchProducts();
        if (products) {
            const sortedProducts = sortProducts
            (products,
                urlParamsObject.sortOption ?? 'price',
                urlParamsObject.sortOrder ?? 'asc'
            );
            const paginatedProducts = paginateProducts(sortedProducts);
            let currentPage;
            let numberOfPages;
            if (paginatedProducts.length > 0) {
                numberOfPages = paginatedProducts.length;
                if (numberOfPages) {
                    if (isPageParamNotSet()) {
                        setPageParamAndRedirect();
                    }
                    currentPage = urlParamsObject.page;
                    setSortingResNumber(paginatedProducts);
                    renderPagination(numberOfPages, currentPage);
                }
                $('.paginator__item').on('click', (e) => {
                    setPageParamAndRedirect(e.target.innerHTML);
                });
                renderShopList(paginatedProducts, currentPage);

                $('.shop__item').click((e) => {
                    window.urlParamsObject.product = {
                        id: '',
                        price: '',
                        deliveryInfo: {},
                    }
                    if (e.target.classList.contains('shop__item')) {
                        e.target.childNodes.forEach((el) => {
                            if (el.id === 'product__id') {
                                window.urlParamsObject.product.id = el.value;
                            }
                            if (el.classList.contains('product__price')) {
                                window.urlParamsObject.product.price = el.innerText.replace(' руб.', '');
                            }
                        });
                    }
                    if (e.target.parentNode.classList.contains('shop__item')) {
                        e.parentNode.childNodes.forEach((el) => {
                            if (el.id === 'product__id') {
                                window.urlParamsObject.product.id = el.value;
                            }
                            if (el.classList.contains('product__price')) {
                                window.urlParamsObject.product.price = el.innerText.replace(' руб.', '');
                            }
                        });
                    }
                });
            }
        }
    }

    if (document.querySelector('.page-order')) {
        const orders = await fetchOrders();

        if (orders) {
            if (await orders.length > 0) {
                renderOrdersList(sortOrders(await orders));
            }
        }
    }

    if (document.querySelector('.page-products')) {
        let products = await fetchProducts();

        if (products) {
            if (products.length !== 0) {
                renderAdminProductsList(products);

                $('.product-item__delete').click(async (e) => {
                    const id = e.target.parentNode.querySelector('#id').innerText;
                    const result = await deleteAdminProduct(id)
                    if (result) {
                        e.target.parentNode.remove()
                    }
                })
            } else {
                renderAdminNoProductsNotice();
            }
        }
    }

    async function fetchOrders() {
        const response = await fetch(location.origin + '/getorders/');
        if (response.ok) {
            const result = await response.json()

            if (result.error && result.error !== 0) {
                alert(result.error);
                return false;
            }

            result.forEach(order => {
                order.delivery_info = JSON.parse(order.delivery_info)
            });
            return result;
        } else {
            alert("Ошибка HTTP: " + response.status);
            return false;
        }
    }

    function sortProducts(productsArray, sortOption, sortOrder) {
        if (sortOption === 'price') {
            productsArray = productsArray.sort((product1, product2) => {
                return sortOrder === 'asc' ? product1.price - product2.price : product2.price - product1.price;
            });
            return productsArray
        }

        if (sortOption === 'title') {
            productsArray = productsArray.sort((product1, product2) => {
                return sortOrder === 'asc' ? product2.title - product1.price : product1.price - product2.title;
            });

            return productsArray;
        }
    }

    function sortOrders(orders) {
        let done = orders.filter(order => order.status === 'Выполнено')
        let notDone = orders.filter(order => order.status === 'Не выполнено')

        return done.concat(notDone);
    }

    function renderOrdersList(orders) {
        orders.forEach((order) => {
            const delivery_info = order.delivery_info;
            const client = delivery_info.client;
            const address = delivery_info.address;

            $('.page-order__list').append('<li class="order-item page-order__item">\n' +
                '                    <div class="order-item__wrapper">\n' +
                '                        <div class="order-item__group order-item__group--id">\n' +
                '                            <span class="order-item__title">Номер заказа</span>\n' +
                '                            <span class="order-item__info order-item__info--id">' + order.id + '</span>\n' +
                '                        </div>\n' +
                '                        <div class="order-item__group">\n' +
                '                            <span class="order-item__title">Сумма заказа</span>\n' + order.price +
                '                             руб.\n' +
                '                        </div>\n' +
                '                        <button class="order-item__toggle"></button>\n' +
                '                    </div>\n' +
                '                    <div class="order-item__wrapper">\n' +
                '                        <div class="order-item__group order-item__group--margin">\n' +
                '                            <span class="order-item__title">Заказчик</span>\n' +
                '                            <span class="order-item__info">' + client.surname + ' ' + client.name + ' ' + (client.thirdName ?? '') + '</span>\n' +
                '                        </div>\n' +
                '                        <div class="order-item__group">\n' +
                '                            <span class="order-item__title">Номер телефона</span>\n' +
                '                            <span class="order-item__info">' + client.phone + '</span>\n' +
                '                        </div>\n' +
                '                        <div class="order-item__group">\n' +
                '                            <span class="order-item__title">Способ доставки</span>\n' +
                '                            <span class="order-item__info">' + (delivery_info.needDelivery ? 'Доставка' : 'Самовывоз') + '</span>\n' +
                '                        </div>\n' +
                '                        <div class="order-item__group">\n' +
                '                            <span class="order-item__title">Способ оплаты</span>\n' +
                '                            <span class="order-item__info">' + delivery_info.paymentMethod + '</span>\n' +
                '                        </div>\n' +
                '                        <div class="order-item__group order-item__group--status">\n' +
                '                            <span class="order-item__title">Статус заказа</span>\n' +
                (order.status === 'Выполнено' ?
                    '<span class="order-item__info order-item__info--yes order-item__info__status">' + order.status + '</span>\n'
                    : '<span class="order-item__info order-item__info--no order-item__info__status">' + order.status + '</span>\n') +
                '                            <button class="order-item__btn">Изменить</button>\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '                    <div class="order-item__wrapper">\n' +
                '                        <div class="order-item__group">\n' +
                '                            <span class="order-item__title">Адрес доставки</span>\n' +
                '                            <span class="order-item__info">г. ' + address.city + ', ул. ' + address.street + ', д.' + address.home + (address.aprt ? ', кв. ' + address.aprt : '') + '</span>\n' +
                '                        </div>\n' +
                '                    </div>\n' +

                '                    <div class="order-item__wrapper">\n' +
                '                        <div class="order-item__group">\n' +
                '                            <span class="order-item__title">Комментарий к заказу</span>\n' +
                '                            <span class="order-item__info">' + delivery_info.comment + '</span>\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '                </li>');
        });
    }

    $('.order-item__btn').click(async (evt) => {
        const orderId = evt.target.closest('.order-item').querySelector('.order-item__info--id').innerHTML;
        const status = evt.target.closest('.order-item').querySelector('.order-item__info__status').innerHTML;
        if (status === 'Выполнено') {
            const result = await changeOrderStatus(orderId, 'Не выполнено');
        } else {
            const result = await changeOrderStatus(orderId, 'Выполнено');
        }

    })

    async function changeOrderStatus(id, status) {
        const response = await fetch(location.origin + '/orders/changeStatus', {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",  // sent request
                "Accept": "application/json"   // expected data sent back
            },
            body: JSON.stringify({id: id, status: status}),
        })
        if (response.ok) {
            const result = await response.json();
            return await result;
        } else {
            alert("Ошибка HTTP: " + response.status);
            return false;
        }
    }

    function renderAdminProductsList(products) {
        products.forEach((product) => {
            $('.page-products__list').append(
                '<li class="product-item page-products__item">\n' +
                '      <b class="product-item__name" id="title">' + product.title + '</b>\n' +
                '      <span class="product-item__field" id="id">' + product.id + '</span>\n' +
                '      <span class="product-item__field" id="price">' + product.price + '</span>\n' +
                '      <span class="product-item__field" id="categories">' + product.categories + '</span>\n' +
                '      <a href="/admin/products/edit?id=' + product.id + '"' + ' class="product-item__edit" aria-label="Редактировать"></a>\n' +
                '      <button class="product-item__delete"></button>\n' +
                '    </li>'
            );
        })
    }

    async function deleteAdminProduct(id) {
        const response = await fetch(location.origin + '/admin/products/delete?id=' + id, {
            method: 'DELETE',
        })
        if (response.ok) {
            const result = await response.json();
            return await result;
        } else {
            alert("Ошибка HTTP: " + response.status);
            return false;
        }
    }

    function renderAdminNoProductsNotice() {
        $('.page-products__header').remove();
        $('.h--1').remove();
        $('.page-products__list').remove();

        const mainPage = document.querySelector('.page-products');

        const noPostsWarning = document.createElement('h1');
        noPostsWarning.className = 'h h--1';
        noPostsWarning.innerHTML = 'Товаров пока что нет';

        mainPage.append(noPostsWarning);
    }

    function setSortingResNumber(paginationArray) {
        let number = 0;
        paginationArray.forEach((arr) => {
            number += arr.length
        });
        document.querySelector('.res-sort').innerHTML = number;
    }

    function isPageParamNotSet() {
        return urlParamsObject.page === undefined || urlParamsObject.page === '' || isNaN(Number(urlParamsObject.page));
    }

    function isURLSearchEmpty() {
        const search =
            location.href.replace(
                location.origin + location.pathname,
                ''
            );
        return (new RegExp('^(\\?)+$').test(search)) || search === '';
    }

    function setPageParamAndRedirect(pageNumber = 1, url = document.location.href) {
        if (isURLSearchEmpty()) {
            url = url.replaceAll('?', '');
            url += `?page=${pageNumber}`;
            location.assign(url);
        } else {
            if (isPageParamNotSet()) {
                url += `&page=${pageNumber}`;
                location.assign(url);
            }
        }
    }

    function initParamsObject(query = location.search.replaceAll('?', '')) {

        query = query.substring(query.indexOf('?') + 1);

        var re = /([^&=]+)=?([^&]*)/g;
        var decodeRE = /\+/g;

        var decode = function (str) {
            return decodeURIComponent(str.replace(decodeRE, " "));
        };

        var params = {}, e;
        while (e = re.exec(query)) {
            var k = decode(e[1]), v = decode(e[2]);
            if (k.substring(k.length - 2) === '[]') {
                k = k.substring(0, k.length - 2);
                (params[k] || (params[k] = [])).push(v);
            } else params[k] = v;
        }

        var assign = function (obj, keyPath, value) {
            var lastKeyIndex = keyPath.length - 1;
            for (var i = 0; i < lastKeyIndex; ++i) {
                var key = keyPath[i];
                if (!(key in obj))
                    obj[key] = {}
                obj = obj[key];
            }
            obj[keyPath[lastKeyIndex]] = value;
        }

        for (var prop in params) {
            var structure = prop.split('[');
            if (structure.length > 1) {
                var levels = [];
                structure.forEach(function (item, i) {
                    var key = item.replace(/[?[\]\\ ]/g, '');
                    levels.push(key);
                });
                assign(params, levels, params[prop]);
                delete (params[prop]);
            }
        }
        window.urlParamsObject = params;
    }

    function renderShopList(paginatedProducts, pageNumber) {
        paginatedProducts[pageNumber - 1].forEach((product) => {
            createProductElement(product);
        });
    }

    function createProductElement(product) {
        const shopListSection = document.querySelector('.shop__list');

        const productCard = document.createElement('article');
        productCard.className = 'shop__item product';
        productCard.tabindex = '0';

        const imageDiv = document.createElement('div');
        imageDiv.className = 'product__image';
        const productImage = document.createElement('img');
        productImage.alt = product.title;
        productImage.src = '/public/img/products/' + product.pic_source;
        imageDiv.append(productImage);

        const productTitle = document.createElement('p');
        productTitle.className = 'product__name';
        productTitle.innerHTML = product.title;

        const productPrice = document.createElement('span');
        productPrice.className = 'product__price';
        productPrice.innerText = product.price + ' руб.';

        const productIdHiddenInput = document.createElement('input');
        productIdHiddenInput.type = 'hidden';
        productIdHiddenInput.id = 'product__id';
        productIdHiddenInput.value = product.id;

        shopListSection.append(productCard);

        productCard.append(imageDiv);
        productCard.append(productTitle);
        productCard.append(productPrice);
        productCard.append(productIdHiddenInput);
    }

    async function fetchProducts() {
        const filterParams = window.location.search.replace('?', '');

        const response = await fetch(location.origin + '/products/?' + filterParams);
        if (response.ok) {
            const result = await response.json();

            if (result.error && result.error !== 0) {
                alert(result.error);
                return false;
            }

            return result;
        } else {
            alert("Ошибка HTTP: " + response.status);
            return false;
        }
    }

    function paginateProducts(products, perPage = 10) {
        let paginationArr = [];

        const prodNumber = products.length;

        for (let i = 0; i < (Math.floor(prodNumber / perPage)) + 1; i++) {
            if (products.length !== 0) {
                paginationArr[i] = products.splice(0, perPage);
            }
        }
        return paginationArr;
    }

    function renderPagination(numberOfPages, currentPageNumber) {
        const shopWrapper = document.querySelector('.shop__wrapper');

        const paginationSection = document.createElement('ul');
        paginationSection.className = 'shop__paginator paginator';
        shopWrapper.append(paginationSection);

        for (let i = 1; i < numberOfPages + 1; i++) {
            const liWrapper = document.createElement('li');

            const paginatorItem = document.createElement('a');
            paginatorItem.className = 'paginator__item';
            if (i != currentPageNumber) {
                paginatorItem.href = location.href.replace(`page=${currentPageNumber}`, `page=${i}`);
            }
            paginatorItem.innerHTML = `${i}`;

            paginationSection.append(liWrapper);
            liWrapper.append(paginatorItem);
        }
    }

    /*
    Filter and Sort Section
     */

    const filters = document.querySelectorAll('input[type="checkbox"]');

    $('#sortOption').val(urlParamsObject.sortOption ?? $('#sortOption').val())
    $('#sortOrder').val(urlParamsObject.sortOrder ?? $('#sortOrder').val())
    $('input[name="sortOption"]').val($('#sortOption').val())
    $('input[name="sortOrder"]').val($('#sortOrder').val())

    $('#sortOption').change((evt) => {
        $('input[name="sortOption"]').val(evt.target.value)
    });

    $('#sortOrder').change((evt) => {
        $('input[name="sortOrder"]').val(evt.target.value)
    });

    filters.forEach((filter) => {
        if (window.urlParamsObject.hasOwnProperty('categories')) {
            if (window.urlParamsObject.categories.split(',').filter((el) => el != '').includes(filter.id)) {
                filter.checked = true;
            }
        }

        if (filter.checked) {
            $('.category__filter').val($('.category__filter').val().split(',').filter((el) => el != '').concat(filter.id).join(','))
        }

        filter.addEventListener('change', (e) => {
            let catsInput = document.querySelector('.category__filter');
            if (e.target.checked) {
                catsInput.value = catsInput.value.split(',').filter((el) => el != '').concat(e.target.id).join(',');
            }
            if (!e.target.checked) {
                catsInput.value = catsInput.value.split(',').filter((el) => el != e.target.id).join(',');
            }
        })
    });

    //slider
    $('.range__line').slider({
        min: 200,
        max: 32000,
        values: [urlParamsObject.minPrice ?? 200, urlParamsObject.maxPrice ?? 32000],
        range: true,

        create: function (event, ui) {
            $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
            $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');
        },
        stop: function (event, ui) {
            $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
            $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');

        },
        slide: function (event, ui) {
            $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
            $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');
        },
    });

    $('.filter__range').parents('form').on('slidestop', function (event, ui) {
        $(this).find('input[name="minPrice"]').val(ui.values[0]);
        $(this).find('input[name="maxPrice"]').val(ui.values[1]);
    });

    $('.filter__range').parents('form').on('slidecreate', function (event, ui) {
        $(this).find('input[name="minPrice"]').val(ui.values[0]);
        $(this).find('input[name="maxPrice"]').val(ui.values[1]);
    });

    $('.button').parents('#filter').on('submit', (event) => {
        if ($('.category__filter').val() === '') {
            $('.category__filter').remove();
        }
    });
});
