## Currency Rates Checker - Demo
### Project Description
Project made as a demo application for Stfalcon. It contains a single console command to retrieve currency exchange rates from Monobank an PrivatBank providers.

### Preparation
To be able to launch the application Brevo API key is required. You can define it in docker-compose.yaml (see `MAILER_DNS` environment variable) or using `import` command inside a `php-fpm` container:
```shell
import MAILER_DSN=brevo+api://<YOUR_BREVO_API_KEY>@default
```
Also, check `SERVICE_NOTIFICATION_RECEIVER` variable and set a valid email address.

### Launching
To launch use console command inside `php-fpm` container:
```shell
php bin/console currency:rates:check
```
or
```shell
docker exec -it stf_php /bin/sh -c "bin/console currency:rates:check"
```

Docker configurations:

`.docker/dev/*` - contains Docker and service configurations for local development;


Services (containers):

`percona (stf_percona)` - Percona driven MySQL database;

`php-fpm (stf_php)` - Application core service;


### Docker Console Commands
Build Local Workspace (build-essential package required):
```shell
make
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
