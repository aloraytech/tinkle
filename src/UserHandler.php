<?php


namespace Tinkle;


abstract class UserHandler extends Model
{


    abstract public function getDisplayName(): string;


}