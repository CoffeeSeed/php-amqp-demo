<?php


namespace Model;


class Payload {

    private $now;

    public function __construct($now) {
        $this->now = $now;
    }

    public function getNow() {
        return $this->now;
    }
}