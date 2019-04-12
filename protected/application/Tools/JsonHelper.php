<?php
/**
 * Created by PhpStorm.
 * User: EVO
 * Date: 18.08.2016
 * Time: 21:58
 */

namespace Tools;


use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class JsonHelper {

    private $serializer;
    private $serializerOptions = JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE;

    public function __construct() {

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);

    }

    public function objectToJson($obj) {
        return $this->getSerializer()->serialize($obj, "json", ["json_encode_options" => $this->serializerOptions]);
    }

    public function jsonToObject($json, string $class) {
        $obj = null;
        try {
            $obj = $this->getSerializer()->deserialize($json, $class, "json", ["json_encode_options" => $this->serializerOptions]);
        }
        catch (\Exception $e) {
        }

        return $obj;
    }

    public function getSerializer() {
        return $this->serializer;
    }

}