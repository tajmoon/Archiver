FROM php:cli
RUN apt-get update && \
     apt-get install -y \
         libzip-dev \
         libbz2-dev \
         && docker-php-ext-install zip \
         && docker-php-ext-install bz2
RUN mkdir /app
WORKDIR /app
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer