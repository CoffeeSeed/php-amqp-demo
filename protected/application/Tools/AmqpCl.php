<?php

namespace Tools;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use PhpAmqpLib\Connection\AMQPSSLConnection;

class AmqpCl {

    private static $instance;

    private $config;

    private $connection;
    /**
     * @var  AMQPChannel
     */
    private $channel;

    private $exchangeName = "php-amqp-demo";
    private $queueName = "php-amqp-demo";

    private $serializer;
    private $serializerOptions = JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE;

    private function __construct() {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);
        $this->connect();
    }

    public static function getInstance() {
        return
            self::$instance === null
                ? self::$instance = new static()
                : self::$instance;
    }

    public function sendMessage($message, $routingKey) {
        $this->channel->basic_publish(new AMQPMessage($this->objectToJson($message)), $this->exchangeName, $routingKey);
    }

    public function addHandler($handler) {
        return $this->channel->basic_consume($this->queueName, '', false, true, false, false, $handler);
    }

    public function wait() {
        $this->channel->wait();
    }


    public function connect() {
        $this->config = ConfigHandler::getConfig("amqp");

        $this->connection = new AMQPSSLConnection(
            $this->config['host'],
            $this->config['port'],
            $this->config['login'],
            $this->config['password'],
            $this->config['vhost']
        );

        $this->channel = $this->connection->channel();
        $this->channel->exchange_declare($this->exchangeName, "topic", false, true, false);
        $this->channel->queue_declare($this->queueName,false, true, false, false);
        $this->channel->queue_bind($this->queueName, $this->exchangeName, "#");

    }

    public function close() {
        $connection = $this->channel->getConnection();
        $this->channel->close();
        $connection->close();
    }

    private function objectToJson($obj) {
        return $this->getSerializer()->serialize($obj, "json", ["json_encode_options" => $this->serializerOptions]);
    }

    public function getSerializer() {
        return $this->serializer;
    }

}
