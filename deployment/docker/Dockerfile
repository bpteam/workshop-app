ARG REGISTRY=myregistry
ARG BASE_PHP_IMAGE=php:8.1

FROM ${REGISTRY}/infra/${BASE_PHP_IMAGE} as app_build

# Set the WORKDIR to /app so all following commands run in /app
WORKDIR /app

# Used to provide fallback strategy(downloading from sources)
ARG GITHUB_OAUTH_TOKEN
ARG GITLAB_OAUTH_TOKEN

# Install Composer and make it available in the PATH
RUN curl -sS https://getcomposer.org/installer | php --  --version=2.2.4 --install-dir=/usr/bin/ --filename=composer \
    && composer global config github-oauth.github.com ${GITHUB_OAUTH_TOKEN} \
    && composer global config gitlab-token.gitlab.com ${GITLAB_OAUTH_TOKEN}

# Copy composer files into the app directory.
COPY composer.json composer.lock symfony.lock ./

# Install dependencies with Composer.
ARG COMPOSER_ARGS='--no-interaction --no-dev --prefer-dist --no-scripts'
RUN composer install ${COMPOSER_ARGS}

# We need to reset stages with stored GITHUB_OAUTH_TOKEN to provide security
FROM ${REGISTRY}/infra/${BASE_PHP_IMAGE}

ARG PHP_OPCACHE_ENABLE="1"
ARG PHP_APC_ENABLED="1"
ARG APP_ENV="prod"
ARG APP_DEBUG="0"

ENV PHP_OPCACHE_ENABLE="${PHP_OPCACHE_ENABLE}" \
    PHP_APC_ENABLED="${PHP_APC_ENABLED}" \
    APP_ENV="${APP_ENV}" \
    APP_DEBUG="${APP_DEBUG}"

WORKDIR /app
COPY --from=app_build /app ./

COPY --chown=${PHP_WWW_USER}:${PHP_WWW_GROUP} ./deployment/docker/php/php.ini /usr/local/etc/php/php.ini
COPY --chown=${PHP_WWW_USER}:${PHP_WWW_GROUP} ./deployment/docker/php/zzz_php.ini /usr/local/etc/php/conf.d/
COPY --chown=${PHP_WWW_USER}:${PHP_WWW_GROUP} . ./

ARG COMPOSER_DUMP_ARGS='--no-dev --classmap-authoritative'

RUN curl -sS https://getcomposer.org/installer | php --  --version=2.2.4 --install-dir=/usr/bin/ --filename=composer \
    && /usr/bin/composer dump-autoload ${COMPOSER_DUMP_ARGS} \
    && rm -f /usr/bin/composer

RUN bin/console cache:clear

CMD ["php-fpm", "-R"]
