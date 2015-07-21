<?php

namespace memclutter\amqp\components;

/**
 * AMQP consumer component.
 */
class Consumer extends BaseComponent
{
    public function consume($routingKey, $callback)
    {
        list($queueName, ,) = $this->channel->queue_declare("", false, false, true, false);
        $this->channel->queue_bind($queueName, $this->exchange, $routingKey);
        $this->channel->basic_consume($queueName, '', false, false, false, false, $callback);
    }

    public function wait()
    {
        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
}