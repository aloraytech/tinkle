<?php


namespace Tinkle;


class Framework extends Tinkle
{


    /**
     * Framework constructor.
     * @param string $rootPath
     * @param array $config
     * @throws Exceptions\Display
     */
    public function __construct(string $rootPath,array $config)
    {
        parent::__construct($rootPath,$config);
        
    }

}