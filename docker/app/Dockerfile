FROM composer:${COMPOSER_VERSION} AS vendor

FROM php:8.2-fpm

USER ${NON_ROOT_USER}

COPY --chown=${NON_ROOT_USER}:${NON_ROOT_USER} --from=vendor /usr/bin/composer /usr/bin/composer
COPY --chown=${NON_ROOT_USER}:${NON_ROOT_USER} src/core/composer* ./

RUN composer install \
  --no-dev \
  --no-interaction \
  --no-autoloader \
  --no-ansi \
  --no-scripts \
  --audit

RUN docker-php-ext-install