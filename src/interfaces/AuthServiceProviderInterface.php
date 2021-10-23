<?php

namespace Tinkle\interfaces;

interface AuthServiceProviderInterface
{


    public function setGuards():array;


    public function setGuardModel():array;

    /**
     * @return int
     */
    public function setExpire():int;

    /**
     * @return int
     */
    public function setTimeout():int;

}