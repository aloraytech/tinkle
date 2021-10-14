<?php


namespace Config;


use Tinkle\interfaces\ConfigInterface;

class App implements ConfigInterface
{

    public function getConfig(): string
    {
        return json_encode([
            'production' => $_ENV['DEV_MODE'],
            'spellCheck' => false,
            'imageBase64'=> true,
            'cache' => true,
            'autoToken'=>true,
            'startOn'=>microtime(true),
        ]);
    }
}