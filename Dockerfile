FROM php:7.1-apache

RUN apt-get update \
&& apt-get install -y wget curl vim python-software-properties software-properties-common

RUN apt-get install -y apt-transport-https lsb-release ca-certificates
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list

RUN apt-get update \
 && apt-get install -y git nano lftp axel git zlib1g-dev libmcrypt-dev libssl-dev libfreetype6-dev \
 && apt-get install -y libjpeg62-turbo-dev libpng12-dev g++ libicu-dev php \
 && docker-php-ext-install zip \
 && docker-php-ext-install opcache \
 && docker-php-ext-install mcrypt \
 && docker-php-ext-install intl \
 && docker-php-ext-install gd \
 && docker-php-ext-install pdo_mysql

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

# checkout, compile and install recent Phalcon extension
RUN cd ~; git clone https://github.com/phalcon/cphalcon -b master --single-branch; cd ~/cphalcon/build; ./install; rm -rf ~/cphalcon \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable phalcon

WORKDIR /var/www
