<?php

use tinkle\framework\Event;
use \tinkle\framework\Tinkle;

//Tinkle::$app->event->setClassAttribute($classAttr);
Tinkle::$app->event->prepare(EVENT::EVENT_ON_REPEAT,'tinkle\framework\Sample::loadData','ss');
Tinkle::$app->event->finish();

Tinkle::$app->event->prepare(EVENT::EVENT_ON_REPEAT,'tinkle\framework\UserController::updateUser',['user'=> 'George']);

//$this->event->setClassAttribute($classAttr);
Tinkle::$app->event->prepare(EVENT::EVENT_ON_RUN,'tinkle\framework\Sample::addPost','as',['auth'=>false,'timer'=>30,'return'=>'bool','mix'=>1]);
Tinkle::$app->event->finish();

