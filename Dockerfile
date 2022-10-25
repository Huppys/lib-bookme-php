FROM php:8.1.10-cli

RUN pecl install ds-1.4.0 && \
        docker-php-ext-enable ds

RUN pecl install xdebug-3.1.5 && \
    docker-php-ext-enable xdebug && \
    echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini &&  \
    echo "xdebug.mode = debug" >> /usr/local/etc/php/conf.d/xdebug.ini &&  \
    echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/xdebug.ini &&  \
    echo "xdebug.client_port = 9003" >> /usr/local/etc/php/conf.d/xdebug.ini \

RUN rm -rf /tmp/pear /tmp/pear-build-root

RUN apt update && \
    apt install -y git libzip-dev

RUN docker-php-ext-install zip
RUN docker-php-ext-enable zip

COPY docker/install-composer.sh /opt/src/composer/install-composer.sh
RUN chmod +x /opt/src/composer/install-composer.sh
RUN /opt/src/composer/install-composer.sh
RUN ln -nfs /usr/local/bin/composer.phar /usr/local/bin/composer

ENV PROJECT_ROOT="/opt/project"

EXPOSE 9003
