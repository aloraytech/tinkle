<?php


namespace Tinkle\Exceptions;


class ExceptionMagic
{

    public function handle(\Throwable $t)
    {
        try{
            $msg = '_msg='.$t->getMessage().'&_line='.$t->getline().'&_file='.$t->getFile().'&_code='. $t->getCode().'&_trace='. $t->getTraceAsString();
            throw new Display("$msg");
        }catch (Display $e)
        {
            $e->handle();
        }


    }


}