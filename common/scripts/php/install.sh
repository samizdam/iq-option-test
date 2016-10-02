#!/usr/bin/env bash

# Get PHP 7
sudo \
  add-apt-repository ppa:ondrej/php && \
  apt-get update && \
  apt-get install -y php7.0-cli && \
  apt-get install -y php-redis && \
  apt-get install -y php-sqlite3 && \
  apt-get install -y php-sqlite3 && \
  apt-get install -y php7.0-xml

# Get Composer
sudo \
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
  php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
  php composer-setup.php && \
  php -r "unlink('composer-setup.php');" && \
  mv composer.phar /usr/local/bin/composer

