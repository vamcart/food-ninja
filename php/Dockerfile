FROM php:8.3-fpm-alpine

WORKDIR /var/www/app

RUN apk update && apk add \
    curl \
    linux-headers \
    libpng-dev \
    libxml2-dev \
    unzip

RUN apk add --no-cache zip libzip-dev

RUN docker-php-ext-install pdo pdo_mysql \
    && apk --no-cache add nodejs npm

RUN apk add --no-cache \
    $PHPIZE_DEPS \
    openssl-dev \
    icu \
    icu-dev \
    zlib-dev 

# xhprof    
RUN pecl install xhprof && \
    docker-php-ext-enable \  
    xhprof 

# Устанавливаем расширение opentelemetry для PHP
RUN pecl install opentelemetry \
    && docker-php-ext-enable opentelemetry


COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

USER root

RUN chmod 777 -R /var/www/app

# Install xdebug
RUN pecl install xdebug-3.5.3 && \
    docker-php-ext-enable xdebug && \
    mkdir /var/log/xdebug

# Other PHP Extensions

RUN docker-php-ext-install -j$(nproc) intl && \
    docker-php-ext-install exif  && \
    docker-php-ext-install zip 

#COPY  ./php/xdebug-nginx.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Add ARGs for syncing permissions
ARG UID=1000
ARG GID=1000

# Create a new user with the specified UID and GID, reusing an existing group if GID exists
RUN if getent group ${GID}; then \
      group_name=$(getent group ${GID} | cut -d: -f1); \
      useradd -m -u ${UID} -g ${GID} -s /bin/bash www; \
    else \
      groupadd -g ${GID} www && \
      useradd -m -u ${UID} -g www -s /bin/bash www; \
      group_name=www; \
    fi

# Dynamically update php-fpm to use the new user and group
RUN sed -i "s/user = www-data/user = www/g" /usr/local/etc/php-fpm.d/www.conf && \
    sed -i "s/group = www-data/group = $group_name/g" /usr/local/etc/php-fpm.d/www.conf


# Switch back to the non-privileged user to run the application
USER www-data