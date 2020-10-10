# https://medium.com/@ahmeeddhon/laravel-docker-using-alpine-1f80fab7359b
# https://github.com/bmeme/docker-library/blob/master/php-dev/7.0.24-apache/Dockerfile
# https://github.com/helderco/docker-php/blob/master/versions/5.6/Dockerfile
# https://codereviewvideos.com/course/docker-tutorial-for-beginners/video/docker-php-7-tutorial-7-7-1-and-higher
# https://medium.com/@alexleeelkins/multi-tenant-laravel-on-ubuntu-18-04-with-nginx-mariadb-and-php-7-3-a09377ef440f
# https://gist.github.com/Stanback/7145487
FROM php:7.3-fpm-alpine

ENV XDEBUG_VERSION 2.8.0
ENV TIMEZONE "America/Sao_Paulo"

RUN apk --update add --no-cache \
    wget \
    curl \
    --virtual .build-deps freetype libxml2-dev \
    git \
    grep \
    libmcrypt \
    libmcrypt-dev \
    libpng \
    libjpeg-turbo \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    build-base \
    libmemcached-dev \
    imagemagick-dev \
    pcre-dev \
    libtool \
    make \
    autoconf \
    g++ \
    cyrus-sasl-dev \
    libgsasl-dev \
    supervisor \
    postgresql \
    postgresql-dev \
    sqlite-libs \
    sqlite-dev \
    zlib-dev \
    # tzdata \
    libzip-dev \
    zip \
    && docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install \
    zip \
    gd \
    mysqli \
    pgsql \
    mbstring \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    pdo_sqlite \
    tokenizer \
    xml \
    && pecl channel-update pecl.php.net \
    && pecl install memcached \
    && pecl install imagick \
    && pecl install redis \
    && docker-php-ext-enable memcached \
    && docker-php-ext-enable opcache \
    && docker-php-ext-enable imagick \
    && docker-php-ext-enable redis \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /tmp/* \
    && rm -rf /var/cache/apk/* && \
    mkdir -p /var/www


# Install xDebug, if enabled, default is no
ARG INSTALL_XDEBUG=false

RUN if $INSTALL_XDEBUG; then \
    # Install the xdebug extension
    echo "Instalando xdebug-$XDEBUG_VERSION" && \
    pecl install xdebug-$XDEBUG_VERSION && \
    docker-php-ext-enable xdebug \
    ;fi

WORKDIR /var/www/html

COPY . /var/www/html

RUN cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && chown -R www-data:www-data /var/www/

# Copy xdebug configration for remote debugging
COPY ./docker/api/xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini

# Copy xdebug configration for remote debugging
RUN if [ "$INSTALL_XDEBUG" = 'false' ]; then \
    # Install the xdebug extension
    echo "Removendo conf xdebug.ini" && \
    rm -rf $PHP_INI_DIR/conf.d/xdebug.ini \
    ;fi

# Copy timezone configration template
# COPY ./docker/api/timezone.ini.template $PHP_INI_DIR/conf.d/timezone.ini.template

# Set timezone in php conf
# RUN sed "s|\${TIMEZONE}|${TIMEZONE}|g" $PHP_INI_DIR/conf.d/timezone.ini.template > $PHP_INI_DIR/conf.d/timezone.ini

# Short open tags fix - another Symfony requirements
COPY ./docker/api/php.ini $PHP_INI_DIR/conf.d/custom-php.ini

COPY ./docker/api/supervisord-api.conf /etc/supervisord.conf

RUN /usr/bin/crontab -u www-data ./docker/api/crontab

COPY ./docker/api/docker-entrypoint.sh /var/www/html/docker/api/docker-entrypoint.sh

# Add entrypoint
COPY ./docker/api/init.d /var/www/html/docker/init.d/

ENTRYPOINT [ "sh" , "./docker/api/docker-entrypoint.sh" ]
