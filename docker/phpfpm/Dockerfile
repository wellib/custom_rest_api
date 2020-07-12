FROM devilbox/php-fpm:7.3-work

RUN apt-get update -qq \
    && apt-get install -qy --no-install-recommends \
        autoconf \
        file \
        g++ \
        gcc \
        libc-dev \
        make \
        cmake \
        curl \
        pkg-config \
        libtool \
        tar \
        libmcrypt-dev \
        libpng-dev \
        libzip-dev \
        zip \
        unzip \
        git \
        wget

# SQLLite
RUN sudo apt-get install -y sqlite3 libsqlite3-dev

# Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'e5325b19b381bfd88ce90a5ddb7823406b2a38cff6bb704b0acc289a09c8128d4a8ce2bbafcd1fcbdc38666422fe2806') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
