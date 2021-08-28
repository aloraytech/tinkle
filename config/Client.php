<?php


namespace Config;


use Tinkle\interfaces\ConfigInterface;

class Client implements ConfigInterface
{

    protected string $license="license.lic";

    public function getConfig(): string
    {
        if(file_exists(__DIR__.$this->license))
        {
            return json_encode(file_get_contents(__DIR__.$this->license));
        }
        return false;
    }

}