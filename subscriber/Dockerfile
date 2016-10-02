FROM php:7.0-cli

# Install redis extension, composer and Supervisor.
RUN \
  apt-get update && \
  pecl install redis && \
  docker-php-ext-enable redis && \
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
  php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
  php composer-setup.php && \
  php -r "unlink('composer-setup.php');" && \
  mv /composer.phar /usr/local/bin/composer && \
  apt-get install -y supervisor && \
  rm -rf /var/lib/apt/lists/* && \
  sed -i 's/^\(\[supervisord\]\)$/\1\nnodaemon=true/' /etc/supervisor/supervisord.conf

# Define mountable directories.
# VOLUME ["/etc/supervisor/supervisord.conf"]
COPY ./etc/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# delivering worker to container
COPY ./subscriber-worker.php /usr/local/sbin/subscriber/subscriber-worker.php
COPY ./src /usr/local/sbin/subscriber/src
COPY ./vendor /usr/local/sbin/subscriber/vendor

# Define working directory.
# WORKDIR /etc/supervisor/conf.d

# Define default command.
CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]