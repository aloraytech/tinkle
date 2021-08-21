<?php


namespace tinkle\framework;


abstract class UserHandler extends Model
{


    abstract public function getDisplayName(): string;


}