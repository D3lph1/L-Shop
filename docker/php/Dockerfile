FROM php:7.1-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        zip \
        unzip \
		libzip-dev \
		libssh-dev \
		libpq-dev \
		libpng-dev \
    && docker-php-ext-install -j$(nproc) pdo_mysql pdo_pgsql zip bcmath sockets gd \
    # Install and enable redis php extension
    && pecl install redis \
    && docker-php-ext-enable redis

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install and start supervisor for queue mechanism
RUN apt-get install -y supervisor

COPY ./supervisor/config /etc/supervisor
COPY ./supervisor/tasks/* /etc/supervisor/conf.d

#ADD php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
