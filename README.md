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
        
## Описание API
Content-Type: application/json

#### Пример ответа успешного запроса

**Code** : `200 OK`

```json
{
    "success": true,
    "data": []
}
```

#### Пример ответа с ошибкой

**Code** : `400 BAD REQUEST`

```json
{
    "success": false,
    "data": {
      "error": "Bad Request"
    }
}
```


### Генерация товаров

Создает 20 произвольных товаров.

**URL** : `/init/`

**Method** : `POST`

**Пример ответа**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Product #8274",
            "price": 222
        },
        {
            "id": 2,
            "name": "Product #7556",
            "price": 222
        },
        {
            "id": 3,
            "name": "Product #2279",
            "price": 222
        }
    ]
}
```

### Создание заказа

В запросе передается список товаров, которые будут собраны в заказ.

**URL** : `/order/`

**Method** : `POST`

**Данные** :

```json
{
    "items": [1,5,7,9]
}
```

**Пример ответа** :

В ответе возвращается
ID заказа, общая сумма заказа, статус и список товаров в заказе.

```json
{
    "success": true,
    "data": {
        "order_id": 1,
        "total": 444,
        "status": "NEW",
        "items": [
            {
                "id": 5,
                "name": "Product #4996",
                "price": 222
            },
            {
                "id": 7,
                "name": "Product #3067",
                "price": 222
            }
        ]
    }
}
```

### Оплата заказа

В запросе передается id заказа и общая сумма заказа.

**URL** : `/payment/{order_id}`

**Method** : `POST`

**Данные** :

```json
{
    "amount": 444
}
```

**Пример ответа** :

При успешной оплате статус заказа меняется на PAID - оплачен.
```json
{
    "success": true,
    "data": {
        "order_id": 1,
        "total": 444,
        "status": "PAID",
        "items": [
            {
                "id": 5,
                "name": "Product #4996",
                "price": 222
            },
            {
                "id": 7,
                "name": "Product #3067",
                "price": 222
            }
        ]
    }
}
```
