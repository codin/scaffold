FROM ubuntu:16.04
MAINTAINER Craig Childs <childscraig17@gmail.com>

RUN apt-get update && \
    apt-get dist-upgrade -y && \
    apt-get install -y \
      apache2 \
      php7.0 \
      php7.0-cli \
      libapache2-mod-php7.0 \
      php7.0-gd \
      php7.0-json \
      php7.0-mbstring \
      php7.0-mysql \
      php7.0-sqlite3

COPY _docker_config/apache_default /etc/apache2/sites-available/000-default.conf
COPY _docker_config/run /usr/local/bin/run

RUN chmod +x /usr/local/bin/run
RUN a2enmod rewrite

WORKDIR /var/www
ADD . /var/www

VOLUME ["/var/www"]

EXPOSE 80
CMD ["/usr/local/bin/run"]