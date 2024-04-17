FROM rabbitmq:3.12.8-management-alpine

RUN apk add --update curl && \
    rm -rf /var/cache/apk/*

RUN mkdir -p /var/log/rabbitmq
RUN chown rabbitmq:rabbitmq /var/log/rabbitmq

CMD ["rabbitmq-server"]