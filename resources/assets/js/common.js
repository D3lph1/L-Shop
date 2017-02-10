/**
 * JavaScript file with main logic
 */

if ($('#sign-in').length > 0) {
    new Vue({
        el: '#sign-in',
        data: {
            username: '',
            password: ''
        },
        methods: {
            login: function () {
                if (this.username.length > 2) {
                    if (this.password.length > 3) {
                        this.$http.post('signin', {
                            '_token': getToken(),
                            'username': this.username,
                            'password': this.password
                        }).then(function (response) {
                            // Success response
                            var body = response.body;
                            var status = body['status'];
                            var self = this;

                            if (status == 'success') {
                                var to = getUrlParams()['to'];
                                msg.setSuccess('Добро пожаловать, ' + self.username + '!');

                                if (to) {
                                    document.location.href = to;
                                } else {
                                    document.location.href = 'servers';
                                }
                            } else if (status == 'invalid_credentials') {
                                msg.danger('Пользователь с такими данными не найден');
                            } else if (status == 'frozen') {
                                msg.danger('Вы произвели слишком большое количество попыток входа. ' +
                                    'Возможность авторизации будет недоступна последующие ' +
                                    body.delay + ' секунд.');
                            }
                        }, function (response) {
                            // Error response
                            msg.danger('Во время выполнения запроса произошла ошибка');
                        })
                    } else {
                        msg.danger('Пароль слишком короткий');
                    }
                } else {
                    msg.danger('Имя пользователя слишком короткое');
                }
            }
        }
    });
}

if ($('#servers-list').length > 0) {
    new Vue({
        el: '#servers-list',
        methods: {
            logout: function () {
                this.$http.get('logout').then(function (response) {
                    document.location.href = 'signin';
                })
            }
        }
    });
}

/**
 * Catalog section
 */
if ($('#content').length > 0) {
    var servVisible = true;
    var cart = new Cart(document.getElementById('server-id').innerText);

    document.getElementById('content').style.width = 'calc(100% - ' + document.getElementById('sidebar').clientWidth + 'px)';
    document.getElementById('content').style.marginLeft = document.getElementById('sidebar').clientWidth + 'px';

    var badHeight = Math.floor(document.getElementById('topbar').clientHeight + document.getElementById('footer').clientHeight);
    document.getElementById('content-container').style.minHeight = 'calc(100vh - ' + badHeight + 'px)';

    document.getElementById('side-content').style.width = document.getElementById('sidebar').clientWidth + 'px';

    document.getElementById('chose-server').onclick = function () {
        switch (servVisible) {
            case true:
                document.getElementById('server-list').style.transform = 'translateX(-150%)';
                document.getElementById('chose-server').getElementsByTagName('I')[0].style.transform = 'rotateZ(180deg)';
                servVisible = false;
                break;
            case false:
                document.getElementById('server-list').style.transform = 'translateX(0)';
                document.getElementById('chose-server').getElementsByTagName('I')[0].style.transform = 'rotateZ(0deg)';
                servVisible = true;
        }
    };

    $('.product-container').hide().eq(0).show();
    $('.cat-btn').eq(0).css({'background-color': '#FF8800'});

    $('.cat-btn').click(function () {
        var tabNumber = $(this).index();
        if ($('.product-container').eq(tabNumber).css('display') == 'none') {
            $('.product-container').eq(tabNumber).siblings().hide();
            $(this).siblings().css({'background-color': '#ffbb33'});
            $(this).css({'background-color': '#FF8800'});
            $('.product-container').eq(tabNumber).fadeIn();
        }
    });
}
/**
 * End
 */
