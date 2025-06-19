FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libbrotli-dev \
    && docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install swoole && docker-php-ext-enable swoole

WORKDIR /var/www

COPY . .

CMD ["php-fpm"]