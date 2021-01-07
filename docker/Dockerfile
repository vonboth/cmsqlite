FROM php:7.4-apache
ARG DEBIAN_FRONTEND=noninteractive

ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync

COPY ./sites-available/000-default.conf /etc/apache2/sites-available
COPY php-ini-overrides.ini /usr/local/etc/php/conf.d

RUN apt-get update && apt-get install -y --no-install-recommends curl zip unzip

RUN install-php-extensions intl xdebug zip

RUN a2enmod rewrite

RUN curl -o composer https://getcomposer.org/download/2.0.8/composer.phar \
  && mv composer /usr/local/bin \
  && chmod +x /usr/local/bin/composer
