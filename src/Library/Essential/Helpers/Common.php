<?php
/**
 * Here Are Listed All Common Helpers..Which can call directly any time anywhere..
 */
use Tinkle\Tinkle;







function Auth()
{
    if(!\Tinkle\Tinkle::isGuest())
    {
        return true;
    }else{
        return false;
    }
}







    function dd($param,$bg_color='yellow',$text_color='black')
    {
        if(!empty($param))
        {
            $bg_color = strtolower($bg_color);
            $text_color = strtolower($text_color);

            echo "<div style='background-color: $bg_color; color: $text_color;border-style: solid;'><h1 style='margin: 4px;'>Direct Display:-</h1><pre style='padding: 5px;margin: 5px;'>";
            print_r($param);
            echo "<br></pre></div>";
            
        }
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