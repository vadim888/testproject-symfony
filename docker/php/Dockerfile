FROM php:7.4.1-fpm

USER root

RUN apt-get update && apt-get install -y \
        sudo \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libwebp-dev \
#        git \
        libicu-dev \
        curl \
        libxml2-dev \
        unzip \
        libzip-dev \
        libonig-dev \
        libpq-dev \
    && pecl install xdebug-2.9.3 \
    && docker-php-ext-enable xdebug \
    && pecl install mcrypt-1.0.3 \
    && docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) iconv bcmath zip gd \
#    && mbstring \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache \
    && docker-php-ext-install sockets \

    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && docker-php-ext-enable pdo_pgsql

#    && docker-php-ext-install -j$(nproc) mysqli pdo_mysql

# GD
#RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
#    && docker-php-ext-install -j "$(nproc)" gd

RUN pecl install apcu \
  && docker-php-ext-enable apcu

#создаем юзера docker
RUN adduser --disabled-password --gecos '' docker
RUN adduser docker sudo
RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Добавим свой php.ini, можем в нем определять свои значения конфига
ADD php.ini /usr/local/etc/php/php.ini

# Указываем рабочую директорию для PHP
WORKDIR /var/www

RUN usermod -u 1000 docker
RUN chown -R docker:docker /var/www
##RUN usermod -u 1000 www-data
##RUN chown -R www-data:www-data /var/www

# Запускаем контейнер
CMD ["php-fpm"]