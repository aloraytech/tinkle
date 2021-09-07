<?php


namespace Tinkle\Library\Render;


interface RenderInterface
{


    /**
     * @param string $template
     * @param mixed $data
     * @return mixed
     */
    public static function resolve(string $template,$data);

    /**
     * @param mixed $content
     * @return mixed
     */
    public static function display($content);


}