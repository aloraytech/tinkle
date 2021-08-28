<?php


namespace Config;


use Tinkle\interfaces\ConfigInterface;

class App implements ConfigInterface
{

    public function getConfig(): string
    {
        return json_encode([
            'production' => false,
            'spellCheck' => false,
            'imageBase64'=> true,
            'cache' => true,
            'autoToken'=>true,
        ]);
    }
}