## Конфигурация: 
- PHP 7.3
- nginx
- sqlite

## Рабочий каталог 
/var/www/htdocs

## Генерация схемы БД
vendor/bin/doctrine orm:schema-tool:create

## Используемые компоненты
  * doctrine/orm
  * doctrine/annotations
  * symfony/routing
  * symfony/http-foundation
  * symfony/dependency-injection
  * symfony/http-kernel
  * guzzlehttp/guzzle
