<?php


namespace Tinkle\Exceptions;


use Tinkle\Exceptions\CoreException;
use Tinkle\Tinkle;

/**
 * Class Display
 * @package Tinkle\Exceptions
 */
class Display extends CoreException
{





    public function Render (bool $display=true){

       $this->RenderException($display,'Rendering Exception','Rendering Traces');


    }












    public function handle()
    {

        parse_str($this->message,$var);
        $data = [
            'message' => $var['_msg'],
            'code' => $var['_code'] ?? $var['_severity'],
            'line' => $var['_line'],
            'file' => $var['_file'],
            'trace' => $var['_trace']??$this->getTraceAsString(),
        ];

        $this->message = $data['message'];
        $this->code = $data['code'];
        $this->line = $data['line'];
        $this->file = $data['file'];




        $this->RenderException(true,'Handle Exception','Handle Traces');

    }





















}