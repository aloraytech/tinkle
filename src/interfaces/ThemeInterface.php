<?php


namespace Tinkle\interfaces;


interface ThemeInterface
{

    public function getInfo():array;
    public function getConfig():array;
    public function getAvailablePages():array;
    public function getAvailableCss():array;
    public function getAvailableJs():array;
    public function getAvailableMedia():array;
    public function isFrontend():bool;
    public function isBackend():bool;
    public function getTemplateEngine():string;


}