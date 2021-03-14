FROM php:7.4-fpm
RUN set -xe \
    && apt-get update \
    && apt-get install -y --no-install-recommends curl \
    && rm -rf /var/lib/apt/lists/*

RUN set -xe \
    && curl -fsSL https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add - \
    && echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" > /etc/apt/sources.list.d/google-chrome.list \
    && apt-get update \
    && apt-get install -y google-chrome-stable \
    && rm -rf /var/lib/apt/lists/*

COPY run.sh /home/docker/script/run.sh
RUN chmod 744 /home/docker/script/run.sh

WORKDIR /var/www/salama
ENTRYPOINT /home/docker/script/run.sh
EXPOSE 9000