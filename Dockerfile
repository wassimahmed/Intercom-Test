# Multi-stage: Composer
FROM composer:1.6 as composer

# Multi-stage: App
FROM php:7.2-cli-alpine

LABEL Maintainer="Waseem Ahmed"

# Adding project code
ADD . /opt/waseem/intercom/

WORKDIR /opt/waseem/intercom

# Copying composer (phar) in the build container to run in there
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install deps & Cleanup
RUN composer install -d /opt/waseem/intercom --no-dev --no-plugins --no-scripts --no-suggest --no-interaction --optimize-autoloader --quiet  \
    && rm /usr/bin/composer \
    && rm /opt/waseem/intercom/composer.*

# Application CLI is our entrypoint
ENTRYPOINT [ "php", "index.php" ]
