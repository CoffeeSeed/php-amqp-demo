<?php
/**
 * Created by PhpStorm.
 * User: Vladislav Egorov
 * Date: 12.05.2016
 * Time: 16:17
 */

namespace Tools;


use Symfony\Component\Yaml\Parser;

class ConfigHandler {

    public static function getConfig(string $name) {
        $yaml = new Parser();
        $value = $yaml->parse(file_get_contents(__DIR__ . "/../config/env/" . APP_ENVIRONMENT. "/$name.yml"));
        return $value;
    }

}
