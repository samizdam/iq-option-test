FROM php:7.0-cli

# Install Supervisor.
RUN \
  apt-get update && \
  apt-get install -y supervisor && \
  rm -rf /var/lib/apt/lists/* && \
  sed -i 's/^\(\[supervisord\]\)$/\1\nnodaemon=true/' /etc/supervisor/supervisord.conf

# Define mountable directories.
# VOLUME ["/etc/supervisor/supervisord.conf"]
COPY ./etc/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./php/src/publisher-worker.php /usr/src/publisher/publisher-worker.php

# Define working directory.
# WORKDIR /etc/supervisor/conf.d

# Define default command.
CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]