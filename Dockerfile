FROM php:7.2-rc-apache

RUN apt-get update \
&& apt-get install -y cron gnupg gnupg2 libcurl4-openssl-dev libedit-dev libsqlite3-dev libssl-dev libxml2-dev wget curl vim

RUN apt-get install -q -y ssmtp mailutils

RUN echo "hostname=localhost.localdomain" > /etc/ssmtp/ssmtp.conf
RUN echo "root=root@example.com" >> /etc/ssmtp/ssmtp.conf
RUN echo "mailhub=maildev" >> /etc/ssmtp/ssmtp.conf
RUN echo "sendmail_path=sendmail -i -t" >> /usr/local/etc/php/conf.d/php-sendmail.ini
RUN echo "localhost localhost.localdomain" >> /etc/hosts

RUN apt-get install -y imagemagick sudo apt-transport-https lsb-release ca-certificates

RUN curl -sL https://deb.nodesource.com/setup_9.x | sudo -E bash -
RUN sudo apt-get install -y nodejs

RUN apt-get install -y libc-client-dev libkrb5-dev libpq-dev gcc zip unzip git supervisor sqlite3 nano lftp axel zlib1g-dev libmcrypt-dev libfreetype6-dev \
&& apt-get install -y libjpeg62-turbo-dev g++ libicu-dev \
&& docker-php-ext-install pgsql mysqli zip opcache intl pdo_mysql pdo_pgsql

RUN apt-get install -y libmemcached-dev \
&& curl -L -o /tmp/memcached.tar.gz "https://github.com/php-memcached-dev/php-memcached/archive/php7.tar.gz" \
&& mkdir -p /usr/src/php/ext/memcached \
&& tar -C /usr/src/php/ext/memcached -zxvf /tmp/memcached.tar.gz --strip 1 \
&& docker-php-ext-configure memcached \
&& docker-php-ext-install memcached \
&& rm /tmp/memcached.tar.gz

RUN apt-get install -y libjpeg62-turbo-dev libmagickwand-dev --no-install-recommends
RUN docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr && docker-php-ext-install gd
RUN pecl install -f imagick && docker-php-ext-enable imagick
RUN pecl install -f mcrypt && docker-php-ext-enable mcrypt
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
&& docker-php-ext-install imap

RUN pecl install -f mongodb \
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

RUN npm install -g socket.io sass yarn gulp bower forever maildev nodemon

ADD crontab /etc/cron.d/app-cron
RUN chmod 0644 /etc/cron.d/app-cron
RUN touch /var/log/cron.log

# RUN { \
#         echo 'opcache.memory_consumption=128'; \
#         echo 'opcache.interned_strings_buffer=8'; \
#         echo 'opcache.max_accelerated_files=4000'; \
#         echo 'opcache.revalidate_freq=60'; \
#         echo 'opcache.fast_shutdown=1'; \
#         echo 'opcache.enable_cli=1'; \
#     } > /usr/local/etc/php/conf.d/opcache-recommended.ini

VOLUME  /var/www
WORKDIR /var/www
