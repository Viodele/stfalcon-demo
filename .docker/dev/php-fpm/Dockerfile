FROM php:8.2.14-fpm-alpine
WORKDIR '/var/www/app'

# --- Copying configs
COPY config/default/php-overrides.ini /usr/local/etc/php/conf.d/99-overrides.ini

# --- PHP Install
RUN apk --no-cache add \
    autoconf \
    build-base \
    libjpeg-turbo-dev \
    libpng-dev \
    freetype-dev \
    libbz2 \
    libzip-dev \
    rabbitmq-c-dev \
    icu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd bcmath bz2 mysqli pdo_mysql zip intl

# --- AMQP Install
RUN pecl install amqp && docker-php-ext-enable amqp

# --- Composer Install
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## --- Xdebug Install
ENV XDEBUG_CONFIG="remote_host=host.docker.internal remote_enable=1"
ENV PHP_IDE_CONFIG="serverName=Docker"
RUN apk add --update linux-headers
RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-3.3.1 \
    && docker-php-ext-enable xdebug

EXPOSE 9000

CMD ["php-fpm"]

# --- Installing Yarn
#RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
#RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
#RUN apt-get update && apt-get install -y yarn
