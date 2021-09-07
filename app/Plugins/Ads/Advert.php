<?php


namespace Plugins\Ads;


use Plugins\Plugins;

class Advert extends Plugins
{


    public function loadFirstAds()
    {

        echo "<div style='background-color: red; color: white;border-style: solid;'><pre style='padding: 5px;margin: 5px;'>";
        echo "<h1>First Ads</h1>Advertising Loaded <br> <a href='#'>click Here To Win</a>";
        echo "<br></pre></div>";

    }

    public function loadSecondAds()
    {
        echo "<div style='background-color: green; color: white;border-style: solid;'><pre style='padding: 5px;margin: 5px;'>";
        echo "<h1>Second Ads</h1>Advertising Loaded <br> <a href='#'>click Here To Win</a>";
        echo "<br></pre></div>";
    }


    public function lastAds()
    {
        echo "<div style='background-color: royalblue; color: white;border-style: solid;'><pre style='padding: 5px;margin: 5px;'>";
        echo "<h1>Last Ads -- On Run</h1>";
        echo "<h3 align='center'><a href='#'>click Here To Subscribe Our News Letter</a></h3>";
        echo "<br></pre></div>";
    }


    public function repeatAdsOne()
    {
        echo "<div style='background-color: hotpink; color: black;border-style: solid;'><pre style='padding: 5px;margin: 5px;'>";
        echo "<h3 align='center'><a href='#'>Repeat Advertisement One</a> </h3>";
        echo "<br> Repeat Object AdsOne</pre> </div>";
    }

    public function repeatAdsTwo()
    {
        echo "<div style='background-color: blueviolet; color: white;border-style: solid;'><pre style='padding: 5px;margin: 5px;'>";
        echo "<h3 align='center'><a href='#'>Repeat Advertisement Two</a></h3>";
        echo "<br>Repeat Object AdsTwo</pre> </div>";
    }




}