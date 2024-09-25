FROM php:8.3-apache
ARG DEBIAN_FRONTEND=noninteractive

#COPY ./sites-available/000-default.conf /etc/apache2/sites-available
#COPY php-ini-overrides.ini /usr/local/etc/php/conf.d

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync

RUN apt-get update && apt-get install -y --no-install-recommends curl zip unzip

RUN install-php-extensions intl xdebug zip

RUN curl -fsSL https://bun.sh/install | bash

RUN a2enmod rewrite

RUN curl -o composer https://getcomposer.org/composer-stable.phar \
  && mv composer /usr/local/bin \
  && chmod +x /usr/local/bin/composer
