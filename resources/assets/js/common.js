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

    if (username.length < 4) {
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

                if (to) {
                    // If the GET parameters "to" exist, then forwards it to the address specified in the parameter
                    document.location.href = to;
                } else {
                    // Otherwise, it forwards the link established with the page rendering
                    document.location.href = $('#sign-in').attr('data-redirect');
                }
            } else {
                if (status == 'invalid_credentials') {
                    msg.danger('Пользователь с такими данными не найден');
                } else if (status == 'frozen') {
                    msg.danger('Вы произвели слишком большое количество попыток входа. ' +
                        'Возможность авторизации будет недоступна последующие ' +
                        response.delay + ' секунд.');
                }
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
 * Perform user registration attempts by pressing the enter key
 */
$('#su-username, #su-email, #su-password, #su-password-confirm').keyup(function (event) {
    if (event.keyCode == 13) {
        signup(this);
    }
});

/**
 * Attempt to register user
 */
$('#btn-sign-up').click(function () {
    signup(this);
});

function signup(self) {
    
}

/**
 * Catalog section
 */
if ($('#content').length) {
    var servVisible = false;

    byId('content').style.width = 'calc(100% - ' + byId('sidebar').clientWidth + 'px)';
    byId('content').style.marginLeft = byId('sidebar').clientWidth + 'px';

    var badHeight = Math.floor(byId('topbar').clientHeight + byId('footer').clientHeight);
    byId('content-container').style.minHeight = 'calc(100vh - ' + badHeight + 'px)';

    byId('side-content').style.width = byId('sidebar').clientWidth + 'px';

    byId('chose-server').onclick = function () {
        switch (servVisible) {
            case true:
                byId('server-list').style.transform = 'translateX(-150%)';
                byId('chose-server').getElementsByTagName('I')[0].style.transform = 'rotateZ(0deg)';
                servVisible = false;
                break;
            case false:
                byId('server-list').style.transform = 'translateX(0)';
                byId('chose-server').getElementsByTagName('I')[0].style.transform = 'rotateZ(180deg)';
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


    byId('btn-menu').onclick = function() {
        byId('side-content').style.transform = 'translateX(0)';
    };

    byId('btn-menu-c').onclick = function() {
        byId('side-content').style.transform = 'translateX(-100%)';
    };

    $('.product-container').hide().eq(0).show();
    $('.cat-btn').eq(0).css({'background-color' : '#FF8800'});
    $('.ad-btn-list').hide();

    $('.admin-menu-btn').click(function() {
        $(this).parent().siblings().find('.ad-btn-list').slideUp();
        $(this).siblings().slideToggle();
    });

    $('.cat-btn').click(function() {
        var tabNumber = $(this).index();
        if ($('.product-container').eq(tabNumber).css('display') == 'none') {
            $('.product-container').eq(tabNumber).siblings().hide();
            $(this).siblings().css({'background-color' : '#ffbb33'});
            $(this).css({'background-color' : '#FF8800'});
            $('.product-container').eq(tabNumber).fadeIn();
        }
    });
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
            var status = response.status;

            if (status == 'success') {
                msg.success('Товар добавлен в корзину');
                disable(self);
                $(self).children('span').text('Уже в корзине');

            } else if (status == 'cart is full') {
                enable(self);
                msg.warning('Невозможно добавить товар. Корзина переполнена.');
            } else if (status == 'already in cart') {
                enable(self);
                msg.warning('Товар уже есть в корзине');
            } else {
                enable(self);
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
(function () {
    var stack;
    var url;
    var price;

    $('.catalog-to-buy').click(function () {
        stack = Number($(this).parent().find('.product-count>span').text());
        url =  $(this).attr('data-url');
        price = Number($(this).parent().find('.catalog-price-span').text());
        $('#catalog-to-buy-name').html($(this).parent().find('.product-name').html());
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
        var self = this;
        var captcha = getCaptcha();
        if (captcha == '') {
            msg.warning('Вы должны подтвердить то, что не являетесь роботом!');
            return;
        }

        // Request
        $.ajax({
            url: url,
            method: 'POST',
            data: ({
                username: $('#catalog-to-buy-username').val(),
                count: $('#catalog-to-buy-count-input').val(),
                captcha: captcha,
                _token: getToken()
            }),
            dataType: 'json',
            beforeSend: function () {
                disable(self);
            },
            success: function (response) {
                enable(self);
                var status = response.status;
                grecaptcha.reset();

                if (status == 'success') {
                    if (response.quick) {
                        msg.success('Покупка успешно совершена!');
                        $('#catalog-to-buy-modal').modal('hide');
                        $('#balance-span').text(response.new_balance);
                    }else {
                        document.location.href = response.redirect;
                    }
                }else {
                    if (status == 'invalid username') {
                        msg.danger('Имя пользователя слишком короткое или содержит недопустимые символы');
                    }
                }
            },

            // Request error
            error: function () {
                enable(self);
                requestError();
            }
        })
    });
})();

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
    var captcha = getCaptcha();

    // Collect products from page
    $.each($('.c-product'), function (index, value) {
        products[index] = new Object(null);
        products[index].id = $(value).find('.c-p-name').attr('data-id');
        products[index].count = $(value).find('.c-p-count-input').val();
    });

    if ($('#c-login').length != 0) {
        username = $('#c-login').val();
        if (username.length < 4) {
            msg.warning('Вы должны указать имя того пользователя (не короче 4 символов), которому хотите приобрести товары.');
            return;
        }
    }

    if (captcha == '') {
        msg.warning('Вы должны подтвердить то, что не являетесь роботом!');
        return;
    }

    $.ajax({
        url: url,
        method: 'POST',
        data: ({
            products: products,
            username: username,
            captcha: captcha,
            _token: getToken()
        }),
        dataType: 'json',
        beforeSend: function () {
            disable(self);
        },
        success: function (response) {
            var status = response.status;
            grecaptcha.reset();

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
            } else {
                enable(self);

                if (status == 'invalid username') {
                    msg.danger('Имя пользователя слишком короткое или содержит недопустимые символы');
                }
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

/**
 * FillUpBalance
 */
$('#fub-btn').click(function () {
    var sum = Number($('#fub-input').val());
    var captcha = getCaptcha();
    var self = this;

    if (isNaN(sum)) {
        msg.warning('Сумма должна иметь числовое значение');
        return;
    }

    if (sum <= 0) {
        msg.warning('Сумма должна быть положительным числом');
        return;
    }

    if (captcha == '') {
        msg.warning('Вы должны подтвердить то, что не являетесь роботом!');
        return;
    }

    // Request
    $.ajax({
        url: '',
        method: 'POST',
        data: ({
            sum: sum,
            captcha: getCaptcha(),
            _token: getToken()
        }),
        dataType: 'json',
        beforeSend: function () {
            disable(self);
        },
        complete: function () {
            grecaptcha.reset();
        },
        success: function (response) {
            status = response.status;

            if (status == 'success') {
                document.location.href = response.redirect;
            }else {
                enable(self);
                if (status == 'invalid sum') {
                    msg.warning('Сумма должна быть положительным числом и быть не меньше ' + response.min);
                }
            }
        },

        // Request error
        error: function () {
            enable(self);
            requestError();
        }
    })
});

$('.profile-payments-info').click(function () {
    var url = $(this).attr('data-url');
    var self = this;
    
    $.ajax({
        url: url,
        method: 'POST',
        data: ({
            _token: getToken()
        }),
        dataType: 'json',
        complete: function () {
            enable(self);
            $('#pre-loader').fadeOut('fast');
        },
        beforeSend: function () {
            disable(self);
            $('#pre-loader').fadeIn('fast');
        },
        success: function (response) {
            $('#profile-payments-modal').modal('show');
            var status = response.status;

            if (status == 'success') {
                var result = '';
                var products = response.products;

                for(i = 0; i < products.length; i++) {
                    result += '<tr><td><img height="35" width="35" src="' + products[i].image + '"></td><td>' + products[i].name + '</td><td>' + products[i].count + '</td></tr>';
                }

                $('#profile-payments-modal-products').html(result);
            }
        },
        error: function () {
            requestError();
        }
    })
});
