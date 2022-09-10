FROM php:8.1.10-cli

RUN pecl install xdebug-3.1.5 && \
    echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini &&  \
    echo "xdebug.mode = debug" >> /usr/local/etc/php/conf.d/xdebug.ini &&  \
    echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/xdebug.ini &&  \
    echo "xdebug.client_port = 9003" >> /usr/local/etc/php/conf.d/xdebug.ini &&  \
    rm -rf /tmp/pear

RUN apt update && \
    apt install -y git libzip-dev

RUN docker-php-ext-install zip

COPY ./install-composer.sh /opt/src/composer/install-composer.sh
RUN chmod +x /opt/src/composer/install-composer.sh
RUN /opt/src/composer/install-composer.sh
RUN ln -nfs /usr/local/bin/composer.phar /usr/local/bin/composer

EXPOSE 9003
