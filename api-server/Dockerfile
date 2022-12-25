FROM php:7.4

# Install unzip utility and libs needed by zip PHP extension
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www
COPY . .

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV PORT=8000

ENTRYPOINT [ "docker/entrypoint.sh" ]
