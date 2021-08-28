<?php

use Tinkle\Event;
use \Tinkle\Tinkle;

//Tinkle::$app->event->setClassAttribute($classAttr);
Tinkle::$app->event->prepare(EVENT::EVENT_ON_REPEAT,'Tinkle\Sample::loadData','ss');
Tinkle::$app->event->finish();

Tinkle::$app->event->prepare(EVENT::EVENT_ON_REPEAT,'Tinkle\UserController::updateUser',['user'=> 'George']);

//$this->event->setClassAttribute($classAttr);
Tinkle::$app->event->prepare(EVENT::EVENT_ON_RUN,'Tinkle\Sample::addPost','as',['auth'=>false,'timer'=>30,'return'=>'bool','mix'=>1]);
Tinkle::$app->event->finish();

