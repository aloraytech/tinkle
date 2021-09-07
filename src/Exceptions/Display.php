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




    public function Render (){

        $data = [
            'message' => $this->message,
            'code' => $this->code,
            'line' => $this->line,
            'file' => $this->file,
            'trace' => $this->getTrace()
        ];

        $this->output($data);


    }


    public function handle()
    {

        parse_str($this->message,$var);
        $data = [
            'message' => $var['_msg'],
            'code' => $var['_code'],
            'line' => $var['_line'],
            'file' => $var['_file'],
            'trace' => $var['_trace'],
        ];

        $this->output($data);

    }







    public function ErrorToException()
    {

        parse_str($this->message,$var);
        $data = [
            'message' => $var['_msg'],
            'code' => $var['_severity'],
            'line' => $var['_line'],
            'file' => $var['_file'],
            'trace' => $this->getTrace()
        ];

        $this->output($data);

    }


    public function CliError()
    {
        echo "\e[92m  Exception Found : "."\n".
                "message :".$this->message ."\n".
                "code : ". $this->code ."\n".
                "line :". $this->line ."\n".
                "file :". $this->file."\n".
                "\n\e[0m";

        die;
    }












    public function Suggession (){

        echo " Exception Found : <br>
                message : $this->message <br>
                code : $this->code <br>
                line : $this->line <br>
                file : $this->file <br>
                
                ";

        die;

    }













}