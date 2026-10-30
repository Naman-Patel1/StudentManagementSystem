
FROM php:8.2-apache

RUN docker-php-ext-install mysqli

RUN echo "output_buffering=On" > /usr/local/etc/php/conf.d/output-buffering.ini

COPY src/ /var/www/html/

COPY css/ /var/www/html/css/

EXPOSE 80
