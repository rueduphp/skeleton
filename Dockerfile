FROM php:7.1-apache

RUN apt-get update \
&& apt-get install -y wget curl vim python-software-properties software-properties-common

RUN apt-get install -y imagemagick sudo apt-transport-https lsb-release ca-certificates
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list

RUN curl -sL https://deb.nodesource.com/setup_9.x | sudo -E bash -
RUN sudo apt-get install -y nodejs

RUN apt-get update \
 && apt-get install -y git nano lftp axel git zlib1g-dev libmcrypt-dev libssl-dev libfreetype6-dev \
 && apt-get install -y libjpeg62-turbo-dev libpng12-dev g++ libicu-dev php \
 && docker-php-ext-install zip \
 && docker-php-ext-install opcache \
 && docker-php-ext-install mcrypt \
 && docker-php-ext-install intl \
 && docker-php-ext-install gd \
 && docker-php-ext-install pdo_mysql

 RUN apt-get install -y libmemcached-dev \
    && curl -L -o /tmp/memcached.tar.gz "https://github.com/php-memcached-dev/php-memcached/archive/php7.tar.gz" \
    && mkdir -p /usr/src/php/ext/memcached \
    && tar -C /usr/src/php/ext/memcached -zxvf /tmp/memcached.tar.gz --strip 1 \
    && docker-php-ext-configure memcached \
    && docker-php-ext-install memcached \
    && rm /tmp/memcached.tar.gz

RUN apt-get update && apt-get install -y \
        libjpeg62-turbo-dev \
        libpq-dev \
        libxml2-dev \
        libmagickwand-dev --no-install-recommends
RUN pecl install imagick && docker-php-ext-enable imagick

RUN pecl install mongodb \
    && echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/ext-mongodb.ini \
    && echo "upload_max_filesize = 500M" > /usr/local/etc/php/conf.d/upload.ini

RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

RUN pecl install -o -f apcu \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable apcu

RUN a2enmod actions rewrite \
 && sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf \
 && mv /var/www/html /var/www/public

RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer


RUN cd ~; git clone https://github.com/phalcon/cphalcon -b master --single-branch; cd ~/cphalcon/build; ./install; rm -rf ~/cphalcon \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable phalcon

RUN npm install -g forever maildev nodemon

VOLUME  /var/www
WORKDIR /var/www
