<?php

namespace Service;

use DateTime;
use Model\Payload;
use PhpAmqpLib\Message\AMQPMessage;
use Tools\AmqpCl;

class TestService {

    private $amqpCl;

    public function __construct() {
        $this->amqpCl = AmqpCl::getInstance();
    }

    public function tapRabbit() {
        $payload = new Payload(date(DateTime::ISO8601));
        $this->amqpCl->sendMessage($payload, "date.send");
        print "Send message with date '" . $payload->getNow() . "'\n";
    }

    public function createConsumer() {
        $callback = function (AMQPMessage $message) {
            print "Received message '" . $message->body . "'\n";
        };

        $this->amqpCl->addHandler($callback);

        return $this->amqpCl;
    }
}
