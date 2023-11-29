FROM phpdockerio/php:8.2-fpm
WORKDIR "/application"

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        php8.2-memcached \
        php8.2-mysql \
        php8.2-redis \
        php8.2-uuid \
        php8.2-xdebug \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN usermod -u 1000 www-data

RUN mkdir /var/www
RUN mkdir /var/www/.composer
RUN mkdir /var/www/.composer/cache
RUN chown -R www-data:www-data /var/www/.composer
