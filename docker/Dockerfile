FROM php:apache-buster
ARG DEBIAN_FRONTEND=noninteractive

ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync

COPY 000-default.conf /etc/apache2/sites-available
COPY php-ini-overrides.ini /usr/local/etc/php/conf.d

RUN install-php-extensions intl xdebug

RUN a2enmod rewrite
