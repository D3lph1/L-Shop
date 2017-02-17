/**
 * JavaScript file with main logic
 */

/**
 * Perform user authentication attempts by pressing the enter key
 */
$('#si-username, #si-password').keyup(function (event) {
    if (event.keyCode == 13) {
        signin(this);
    }
});

/**
 * Attempt to auth user
 */
$('#btn-sign-in').click(function () {
    signin(this);
});

function signin(self) {
    var username = $('#si-username').val();
    var password = $('#si-password').val();

    if (username.length < 3) {
        msg.danger('Имя пользователя слишком короткое');

        return;
    }

    if (password.length < 4) {
        msg.danger('Пароль слишком короткий');

        return;
    }

    // Request
    $.ajax({
        url: $('#sign-in').attr('data-url'),
        method: 'POST',
        data: ({
            username: username,
            password: password,
            _token: getToken()
        }),
        dataType: 'json',
        beforeSend: function () {
            disable(self);
        },
        success: function (response) {
            enable(self);
            var status = response.status;

            if (status == 'success') {
                // If a user has successfully logged in
                var to = getUrlParams()['to'];
                msg.setSuccess('Добро пожаловать, ' + username + '!');

                if (to) {
                    // If the GET parameters "to" exist, then forwards it to the address specified in the parameter
                    document.location.href = to;
                } else {
                    // Otherwise, it forwards the link established with the page rendering
                    document.location.href = $('#sign-in').attr('data-redirect');
                }
            } else if (status == 'invalid_credentials') {
                msg.danger('Пользователь с такими данными не найден');
            } else if (status == 'frozen') {
                msg.danger('Вы произвели слишком большое количество попыток входа. ' +
                    'Возможность авторизации будет недоступна последующие ' +
                    response.delay + ' секунд.');
            }
        },

        // Request error
        error: function () {
            enable(self);
            requestError();
        }
    });
}

/**
 * Catalog section
 */
if ($('#content').length) {
    var servVisible = true;

    byId('content').style.width = 'calc(100% - ' + byId('sidebar').clientWidth + 'px)';
    byId('content').style.marginLeft = byId('sidebar').clientWidth + 'px';

    var badHeight = Math.floor(byId('topbar').clientHeight + byId('footer').clientHeight);
    byId('content-container').style.minHeight = 'calc(100vh - ' + badHeight + 'px)';

    byId('side-content').style.width = byId('sidebar').clientWidth + 'px';

    byId('chose-server').onclick = function () {
        switch (servVisible) {
            case true:
                byId('server-list').style.transform = 'translateX(-150%)';
                byId('chose-server').getElementsByTagName('I')[0].style.transform = 'rotateZ(180deg)';
                servVisible = false;
                break;
            case false:
                byId('server-list').style.transform = 'translateX(0)';
                byId('chose-server').getElementsByTagName('I')[0].style.transform = 'rotateZ(0deg)';
                servVisible = true;
        }
    };

    /**
     * Sidebar on mobile
     */
    byId('btn-menu').onclick = function () {
        byId('side-content').style.transform = 'translateX(0)';
    };

    byId('btn-menu-c').onclick = function () {
        byId('side-content').style.transform = 'translateX(-100%)';
    };
}
/**
 * End
 */

/**
 * Put product in cart
 */
$('.catalog-to-cart').click(function () {
    var url = $(this).attr('data-url');
    var self = this;

    // Request
    $.ajax({
        url: url,
        method: 'POST',
        data: ({
            _token: getToken()
        }),
        dataType: 'json',
        beforeSend: function () {
            disable(self);
        },
        success: function (response) {
            enable(self);
            var status = response.status;

            if (status == 'success') {
                msg.success('Товар добавлен в корзину');
                disable(self);
                $(self).children('span').text('Уже в корзине');

            } else if (status == 'cart is full') {
                msg.warning('Невозможно добавить товар. Корзина переполнена.');
            } else if (status == 'already in cart') {
                msg.warning('Товар уже есть в корзине');
            } else {
                msg.danger('Неудалось положить товар в корзину');
            }
        },

        // Request error
        error: function () {
            enable(self);
            requestError();
        }
    })
});

/**
 * Buy product from catalog page
 */

var stack;
var dataUrl;
var price;

$('.catalog-to-buy').click(function () {
    stack = Number($(this).parent().find('.product-count>span').text());
    dataUrl =  $(this).attr('data-url');
    price = Number($(this).parent().find('.catalog-price-span').text());
    $('#catalog-to-buy-count-input').val(stack);
    $('#catalog-to-buy-modal').modal('show');
    $('#catalog-to-buy-summ').text(price);
});

$('#catalog-to-buy-minus-btn').click(function () {
    var input = $(this).parent().parent().find('#catalog-to-buy-count-input');
    var val = Number(input.val());
    if (val - stack > 0) {
        var result = val - stack;
        input.val(result);
        $(this).parent().parent().parent().find('#catalog-to-buy-summ').text(result / stack * price);
    }
});

$('#catalog-to-buy-plus-btn').click(function () {
    var input = $(this).parent().parent().find('#catalog-to-buy-count-input');
    var val = Number(input.val());
    var result = val + stack;
    input.val(result);
    $(this).parent().parent().parent().find('#catalog-to-buy-summ').text(result / stack * price);
});

$('#catalog-to-buy-count-input').blur(function () {
    var val = Number($(this).val());

    if (val % stack != 0) {
        // Normalize input value
        var result = Math.round(val / stack) * stack;
        if (isNaN(result)) {
            result = 0;
        }

        if (result != 0) {
            $(this).val(result);
            $(this).parent().parent().find('#catalog-to-buy-summ').text(result / stack * price);
        } else {
            $(this).val(stack);
            $(this).parent().parent().parent().find('#catalog-to-buy-summ').text(price);
        }
    }

    // If input was empty
    if (val <= 0) {
        $(this).val(stack);
    }
});

$('#catalog-to-buy-accept').click(function () {
    $.ajax({
        url: url,
        method: 'POST',
        data: ({
            _token: getToken()
        }),
        dataType: 'json',
        beforeSend: function () {
            disable(self);
        },
        success: function (response) {

        }
    })
});

/**
 * End
 */

/**
 * Cart section
 */

/**
 * Remove product from cart
 */
$('.cart-remove').click(function () {
    var url = $(this).attr('data-url');
    var self = this;

    // Request
    $.ajax({
        url: url,
        method: 'POST',
        data: ({
            _token: getToken()
        }),
        dataType: 'json',
        beforeSend: function () {
            disable(self);
        },
        success: function (response) {
            enable(self);
            var status = response.status;

            if (status == 'success') {
                msg.info('Товар убран из корзины');

                // Change total cost
                var cost = Number($(self).parents('.c-product').find('.c-p-pay-money>span').text());
                var total = Number($('#total-money>span').text());
                $('#total-money>span').text(total - cost);
                $(self).parents('.c-product').remove();

                // If there are no more elements
                if ($('.c-product').length == 0) {
                    $('#total').remove();
                    $('#cart-products').html('<h3>Корзина пуста</h3>');
                }
            } else if (status == 'product not found') {
                msg.warning('Товар в корзине не найден');
            } else {
                msg.danger('Неудалось убрать товар из корзины');
            }
        },

        // Request error
        error: function () {
            enable(self);
            requestError();
        }
    });
});

/**
 * Increase the number of goods in a cart
 */
$('.cart-minus-btn').click(function () {
    // Number of items in one stack
    var stack = Number($(this).parent().attr('data-stack'));
    // Price for one stack
    var price = Number($(this).parent().attr('data-price'));
    // Current number of goods
    var input = $(this).parent().parent().find('.c-p-count-input');
    var val = Number(input.val());
    if (val - stack > 0) {
        var result = val - stack;
        input.val(result);
        $(this).parent().parent().find('.c-p-pay-money>span').text(result / stack * price);

        var total = Number($('#total-money>span').text());
        $('#total-money>span').text(total - price);
    }
});

/**
 * Reduce the quantity of goods in a cart
 */
$('.cart-plus-btn').click(function () {
    // Number of items in one stack
    var stack = Number($(this).parent().attr('data-stack'));
    // Price for one stack
    var price = Number($(this).parent().attr('data-price'));
    // Current number of goods
    var input = $(this).parent().parent().find('.c-p-count-input');
    var val = Number(input.val());
    var result = val + stack;
    input.val(result);
    $(this).parent().parent().find('.c-p-pay-money>span').text(result / stack * price);

    var total = Number($('#total-money>span').text());
    $('#total-money>span').text(total + price);
});

/**
 * Normalize the input value on input blur event
 */
$('.c-p-count-input').blur(function () {
    var stack = Number($(this).parents('.c-2-info').find('.c-p-cbuttons').attr('data-stack'));
    var price = Number($(this).parent().parent().find('.c-p-cbuttons').attr('data-price'));
    var val = Number($(this).val());
    console.log(price);
    if (val % stack != 0) {
        // Normalize input value
        var result = Math.round(val / stack) * stack;
        if (isNaN(result)) {
            result = 0;
        }

        if (result != 0) {
            $(this).val(result);
            $('#total-money>span').text(result / stack * price);
        } else {
            $(this).val(stack);
            $('#total-money>span').text(price);
        }
    }

    // If input was empty
    if (val <= 0) {
        $(this).val(stack);
    }
});

$('#btn-cart-go-pay').click(function () {
    var url = $(this).attr('data-url');
    var self = this;
    var products = new Object(null);
    var username;

    $.each($('.c-product'), function (index, value) {
        products[index] = new Object(null);
        products[index].id = $(value).find('.c-p-name').attr('data-id');
        products[index].count = $(value).find('.c-p-count-input').val();
    });

    if ($('#c-login').length != 0) {
        username = $('#c-login').val();
        if (username.length < 4) {
            msg.warning('Вы должны указать имя того пользователя, которому хотите приобрести товары.');
            return;
        }
    }
    $.ajax({
        url: url,
        method: 'POST',
        data: ({
            products: products,
            username: username,
            _token: getToken()
        }),
        dataType: 'json',
        beforeSend: function () {
            disable(self);
        },
        success: function (response) {
            enable(self);
            var status = response.status;

            if (status == 'success') {
                if (response.quick) {
                    msg.success('Покупка совершена успешно!');
                    $('#balance-span').text(response.new_balance);
                    $('#cart-products').empty();
                    $('#total').remove();
                    $('#cart-products').html('<h3>Корзина пуста</h3>');
                }else {
                    document.location.href = response.redirect;
                }
            } else if (status == 'invalid product id') {
                msg.danger('Один или несколько идентификаторов товаров не совпадают. Перезагрузите страницу и попробуйте снова.');
            } else if (status == 'invalid count') {
                msg.danger('Указано неверное количество товара.');
            }
        },

        // Request error
        error: function () {
            enable(self);
            requestError();
        }
    })
});

/**
 * End
 */
