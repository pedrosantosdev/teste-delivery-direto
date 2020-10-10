FROM nginx:alpine

RUN apk --update add supervisor

WORKDIR /var/www/html

# ensure www-data user exists
# set -x ; \
#     addgroup -g 1000 -S www-data ; \
#     adduser -u 1000 -D -S -G www-data www-data && exit 0 ; exit 1 \

RUN cp /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime \
    && rm /var/cache/apk/*

COPY ./docker/proxy/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/proxy/supervisord-proxy.conf /etc/supervisord.conf

COPY ./docker/proxy/docker-entrypoint.sh /var/www/html/docker/proxy/docker-entrypoint.sh

# Add entrypoint
COPY ./docker/proxy/init.d /var/www/html/docker/init.d/


ENTRYPOINT [ "sh" , "./docker/proxy/docker-entrypoint.sh" ]

# ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]