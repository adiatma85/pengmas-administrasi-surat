FROM php:8.1-fpm-alpine

# Enable zip
RUN apk add \
        libzip \
        zip \
  && docker-php-ext-install zip

# Enable exif
RUN docker-php-ext-install exif

RUN apk add --no-cache nginx wget

RUN mkdir -p /run/nginx

COPY docker/nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /app
COPY . /app
COPY ./src /app

RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"
RUN cd /app && \
    /usr/local/bin/composer install --no-dev

RUN chown -R www-data: /app

CMD sh /app/docker/startup.sh