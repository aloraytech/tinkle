<?php
/**
 * Here Are Listed All Common Helpers..Which can call directly any time anywhere..
 */
use tinkle\framework\Tinkle;

function Auth()
{
    if(!\tinkle\framework\Tinkle::isGuest())
    {
        return true;
    }else{
        return false;
    }
}


    function getAllContentFrom(string $_url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }




    function getMetaTag($_source)
    {




    }









//function extend(string $layout)
//{
//    return ['layout' => $layout];
//}
//
//function assets(string $link)
//{
//
//
//}