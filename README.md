# Template php app

## Start

- Change namespace from AppName to your app name (__NOT__ `APP` 🙏) - find all mentions by search `AppName` or `app-name` or `app_name`
- Change service names in deployment/values-prod.yml and deployment/values-local.yml

## Local run

```
php -S 0.0.0.0:8080 public/index.php
```

## Tests

### Run tests

First run

Warmup app

```
bin/console c:c --env=test 
```

Create test database

```
bin/console --env=test doctrine:database:drop --if-exists --force 
bin/console --env=test doctrine:database:create --if-not-exists
```

Run migrations and fixtures

```
bin/console --env=test doctrine:migrations:migrate --no-interaction --allow-no-migration
bin/console --env=test doctrine:fixtures:load --group=dev --no-interaction --purger=wo_dict_purger
```

Run tests

```
php bin/phpunit tests
```

### Load fixtures

```
php bin/console doctrine:fixtures:load --group=dev
```