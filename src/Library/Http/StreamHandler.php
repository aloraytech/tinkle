<?php


namespace Tinkle\Library\Http;

use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class StreamHandler
{
    public StreamHandler $stream;

    /**
     * StreamHandler constructor.
     */
    public function __construct()
    {
        $this->stream = new StreamedResponse();

    }


}