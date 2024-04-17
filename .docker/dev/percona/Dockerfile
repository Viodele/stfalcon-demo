FROM percona:8.0.34-26

RUN chown -R mysql:mysql /var/lib/mysql

# TODO: Copy instead of adding and set port dynamically from env file
ADD config/my.cnf /etc/mysql/conf.d/my.cnf

CMD ["mysqld"]

EXPOSE 3306
