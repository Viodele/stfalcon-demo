## Teaser Control Core Application
### Project Description
Environmental configuration files:

`.env.dev` - contains settings for Staging (development) environment;

`.env.prod` - contains setting for Production environment;


Docker configurations:

`.docker/dev/*` - contains Docker and service configurations for Staging;

`.docker/prod/*` - contains Docker and service configurations for Production;


Services (containers):

`mysql (tc_mysql)` - Percona driven MySQL database;

`nginx (tc_nginx)` - Nginx driven web-server (API based);

`php-fpm (tc_php)` - API server PHP core;


### Docker Console Commands
Build Local Workspace
```bash
make
```
or
```bash
make dev
```
Build With Production Targeting
```bash
make prod
```
Run Containers With Docker Compose:
```shell
docker-compose up -d --build --force-recreate
```
Stop All:
```shell
docker-compose down -v --remove-orphans
```
or
```shell
docker stop $(docker ps -a -q)
```
Enter PHP Container:
```shell
docker exec -it stf_php /bin/sh
```
Show logs:
```shell
docker-compose logs -f
```

---

### Launching Local Tests

- Launch all tests
```bash
make test
```

- PHP CodeSniffer (codestyle check):
  `
  bin/phpcs --standard=phpcs.xml -s -p -w
  `

Launch now:
```shell
docker exec -it stf_php bin/phpcs --standard=phpcs.xml -s -p -w
```
