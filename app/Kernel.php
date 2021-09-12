<?php


namespace App;


use Tinkle\Framework;
use Tinkle\Exceptions\Display;
class Kernel extends Framework
{


    /**
     * Framework constructor.
     * @param string $rootPath
     * @param array $config
     * @throws Display
     */
    public function __construct(string $rootPath,array $config)
    {
        parent::__construct($rootPath,$config);
        
    }

}