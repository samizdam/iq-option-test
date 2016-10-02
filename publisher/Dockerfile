FROM php:7.0-cli

# Install php extensions and Supervisor.
RUN \
  apt-get update && \
  apt-get install -y zlib1g-dev && \
  pecl install zip && \
  docker-php-ext-enable zip && \
  pecl install redis && \
  docker-php-ext-enable redis && \
  apt-get install -y supervisor

# Install composer and required vendors libs
RUN \
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
  php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
  php composer-setup.php && \
  php -r "unlink('composer-setup.php');" && \
  mv /composer.phar /usr/local/bin/composer

# Define mountable directories.
COPY ./etc/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# delivering worker to container
COPY ./publisher-worker.php /usr/local/sbin/publisher/publisher-worker.php
COPY ./src /usr/local/sbin/publisher/src
COPY ./composer.json /usr/local/sbin/publisher/composer.json
COPY ./composer.lock /usr/local/sbin/publisher/composer.lock

RUN \
  cd /usr/local/sbin/publisher && \
  composer install --prefer-dist --no-dev

# Define default command.
CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]