<?php
//
use Tinkle\Event;
//
//
//
//
Event::set(Event::EVENT_ON_LOAD,'ads.first',[\Plugins\Ads\Advert::class,'loadFirstAds']);
Event::set(Event::EVENT_ON_END,'ads.second',[\Plugins\Ads\Advert::class,'loadSecondAds']);
//
//
Event::set(Event::EVENT_ON_RUN,'ads.last',[\Plugins\Ads\Advert::class,'lastAds'],eventConfig(2,true,20,3));
//
Event::set(Event::EVENT_ON_REPEAT,'test.repeat',[\Plugins\Ads\Advert::class,'repeatAds'],['timer'=>15,'wakeup'=>true,'slot'=>2]);
Event::set(Event::EVENT_ON_REPEAT,'test.repeats',[\Plugins\Ads\Advert::class,'repeatTwo'],['timer'=>0,'wakeup'=>true,'slot'=>3]);
//
//
Event::set(Event::EVENT_ON_RUN,'ads.first',[\Plugins\Ads\Advert::class,'loadFirstAds']);
Event::set(Event::EVENT_ON_RUN,'ads.second',[\Plugins\Ads\Advert::class,'loadSecondAds']);
//
Event::set(Event::EVENT_ON_RUN,'login', function(){
    echo 'Event user login fired! <br>';
});
//
