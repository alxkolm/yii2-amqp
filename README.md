# yii2-amqp
Extension Yii2 for working with AMQP protocol
# installation
Via composer

    composer require "memclutter/yii2-amqp"
    
or add composer.json

```json
{
    "require": {
        "memclutter/yii2-amqp": "*"
    }
}
```

# configuration
Create amqp component config

```php
[
    'components' => [
        'amqp' => [
            'class' => 'memclutter\amqp\components\Amqp',
            'host' => 'localhost',
            'user' => 'guest',
            'pass' => 'guest',
            'vhost' => '/',
        ],
        
        'exchanges' => [
            'exchange' => [
                'type' => 'topic',
                'options' => ['durable' => true],
            ],
            'alternative' => [
                'type' => 'fanout',
                'options' => ['autoDelete' => false],
            ],
        ],
    ],
];
```

# usage
Create producer.

```php
// create producer for work with default exchange
$producer = new memclutter\amqp\components\Producer();
$message = 'my message';
$routingKey = 'my.routing.key';
$producer->publish($message, $routingKey);
```

Listen messages using consumer component

```php
// consumer for default exchange
$consumer = new memclutter\amqp\components\Consumer();
$callback = function($message) {
    echo $message->body;
};
$routingKey = 'my.routing.key';
$consumer->consume($callback, $routingKey);
$consumer->wait();
```