FROM php:8.1.10-cli

RUN pecl install xdebug-3.1.5 && \
    echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini &&  \
    echo "xdebug.mode = debug" >> /usr/local/etc/php/conf.d/xdebug.ini &&  \
    echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/xdebug.ini &&  \
    echo "xdebug.client_port = 9003" >> /usr/local/etc/php/conf.d/xdebug.ini &&  \
    rm -rf /tmp/pear
EXPOSE 9003
