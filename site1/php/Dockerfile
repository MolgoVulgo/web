FROM php:8.0-fpm

RUN apt update \
    && apt install -y nano zlib1g-dev g++ git libicu-dev zip libzip-dev zip libonig-dev libpng-dev libjpeg-dev libxml2-dev libfreetype6-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql xml mbstring \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN docker-php-ext-configure gd \
    && docker-php-ext-install gd

RUN curl -fsSL https://deb.nodesource.com/setup_14.x | bash
RUN apt-get install -y nodejs
RUN apt update && apt-get install -y
RUN npm install --global yarn


WORKDIR /var/www/symfony_docker

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash