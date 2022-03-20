FROM php:7.4-apache

# ENV DEBIAN_FRONTEND noninteractive

ARG owner=klaxoon
ARG projectdir=/var/www/klaxoon

#Setting Debian frontend to noninteractive
RUN echo 'debconf debconf/frontend select Noninteractive' | debconf-set-selections

# Update
RUN apt-get -y update --fix-missing --allow-releaseinfo-change && \
    apt-get upgrade -y && \
    apt-get install -y --no-install-recommends apt-utils && \
    apt-get autoremove -y

# Openssl update (Version 1.1.1i installation)
# Think about commenting those lines of /etc/apt/sources.list file after docker container creation
# Think about editing /etc/ssl/openssl.cnf file after docker container creation (To be able to authenticate to SQL Server Databases)
# Set line CipherString = DEFAULT@SECLEVEL=2 To CipherString = DEFAULT@SECLEVEL=1
RUN echo 'deb https://ftp.debian.org/debian bullseye main' >> /etc/apt/sources.list && \
    echo 'deb-src https://ftp.debian.org/debian bullseye main' >> /etc/apt/sources.list && \
    echo 'deb https://security.debian.org/debian-security bullseye-security main' >> /etc/apt/sources.list && \
    apt-get -y update && \
    rm -rf /var/lib/apt/lists/*

# Install useful tools and important libaries and set pecl extensions dir to php.ini
RUN apt-get -y update && \
    apt-get install -y --no-install-recommends nano\
        wget\
        dialog\
        sqlite3\
        libsqlite3-dev\
        unzip\
        libzip-dev\
        libicu-dev\
        build-essential\
        zip\
        libcurl4-openssl-dev\
        openssl \
        gnupg2 \
        iputils-ping &&\
    pecl config-set php_ini /usr/local/etc/php/php.ini && \
    apt-get -y --no-install-recommends install acl && \
    rm -rf /var/lib/apt/lists/* && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#RUN ls -l /var/lib/dpkg/info | grep -i package_name && \
#    mv /var/lib/dpkg/info/package-name.* /tmp && \
#    rm -r /var/lib/dpkg/info/package-name.* && \
#    apt -y update
RUN apt-get install -y curl apt-transport-https

# Install xdebug, sqlsrv extensions and set php memory limit
RUN pecl install xdebug-2.8.0 && \
    echo 'memory_limit = 512M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;

# Other PHP7 Extensions
RUN docker-php-ext-install zip && \
    docker-php-ext-install -j$(nproc) intl && \
    docker-php-ext-install gettext && \
    docker-php-ext-install exif && \
    docker-php-ext-install sockets

# Cleanup
RUN rm -rf /usr/src/*

WORKDIR ${projectdir}

RUN useradd -ms /bin/bash ${owner} && \
    passwd -d ${owner} && \
    chown -R ${owner} ${projectdir} && \
    chgrp -R www-data ${projectdir} && \
    chmod -R g+w ${projectdir}

USER ${owner}