FROM php:7.4.33-zts-bullseye

RUN apt-get install curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update

WORKDIR /app
COPY . /app

CMD php artisan serve --host=0.0.0.0 --port=8181
EXPOSE 8181
