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
