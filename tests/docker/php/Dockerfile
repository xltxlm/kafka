FROM php:fpm
COPY deb.list /etc/apt/sources.list
COPY / /root/

RUN cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime \
    && cp -f /root/phpunit-5.5.4.phar /usr/local/bin/phpunit \
    && chmod +x /usr/local/bin/phpunit \
    && ln -snf /var/www/html/docker/php/php.ini /usr/local/etc/php/conf.d/ \
    && apt-get -y update && apt-get -y install librdkafka-dev  \
    && pecl install rdkafka && echo "extension=rdkafka.so" >/usr/local/etc/php/conf.d/kafka.ini

