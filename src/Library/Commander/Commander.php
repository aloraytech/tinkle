<?php


namespace tinkle\framework\Library\Commander;


use tinkle\framework\Tinkle;

class Commander extends CommandHandler
{

    public function setConfig(array $config): array
    {
        return $this->config = $config;
    }


    public function setCommandsPath(string $path): string
    {
        return __DIR__."/commands.php";
    }
}