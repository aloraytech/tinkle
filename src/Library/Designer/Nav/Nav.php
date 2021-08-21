<?php


namespace tinkle\framework\Library\Designer\Nav;


class Nav
{

    private array $buttonList=[];
    private array $dropButtonList=[];
    private string $bgColor;




    public function start(string $_navColor,string $_bgColor = '')
    {


        if(empty($_bgColor)){$_bgColor = 'light';}
        if(empty($_navColor)){$_navColor = 'light';}

        echo sprintf('
    <nav class="navbar navbar-expand-lg navbar-%s bg-%s">
        <div class="container-fluid">',strtolower($_navColor),strtolower($_bgColor));
        return new Nav();
    }



    public function branding(string $_link,string $_title,string $txtColor)
    {
        echo sprintf('<a class="navbar-brand %s" href="%s">%s</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">',$txtColor,$_link,$_title);
    }









    public function search(string $_submitTo,string $_label)
    {
        echo sprintf('<form class="d-flex" action="%s" method="post">
                <input class="form-control me-2" type="search" placeholder="%s" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">%s</button>
            </form>',$_submitTo,$_label,$_label);
    }






    public function buildButton(string $link,string $title,bool $active=false)
    {
        if(is_string($link) && is_string($title) && is_bool($active))
        {
            if($active != true)
            {
                $active =0;
            }

            $this->buttonList[] = [
                'link'=>$this->buildLink($link),
                'title'=>$title,
                'active'=>$active
            ];
        }
        return $this->buttonList;

    }



    public function buildDropDownButton(string $listName='',string $link,string $title)
    {
        if(is_string($link) && is_string($title))
        {


            $this->dropButtonList[] = [
                'listName' => $listName,
                'link'=>$this->buildLink($link),
                'title'=>$title,
            ];
        }
        return $this->dropButtonList;

    }

    private function buildLink(string $link)
    {
        return $_SERVER['URL_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.$link;
    }




    public function generateButtons(string $_Color='',string $_bgColor = '',array $_btnArray=[],$_dropDownBtnArray=[])
    {



        echo '<ul class="navbar-nav me-auto mb-2 mb-lg-0">';

        if(is_array($_btnArray) && is_array($_dropDownBtnArray))
        {

                // Navbar Buttons List
                if(!empty($_btnArray))
                {
                    foreach ($_btnArray as  $buttons)
                    {
                        if(is_array($buttons))
                        {
                            foreach ($buttons as $btn)
                            {
                                if($btn['active'] === 1 || $btn['active'] === true)
                                {
                                    echo sprintf('<li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="%s">%s</a>
                </li>',$btn['link'],$btn['title']);
                                }else{
                                    echo sprintf('<li class="nav-item">
                    <a class="nav-link %s" aria-current="page" href="%s">%s</a>
                </li>',$_Color,$btn['link'],$btn['title']);
                                }
                            }
                        }
                    }
                }

                // Navbar Default Button Complete

                // NAVBAR DROPDOWN BUTTON LIST START

            echo sprintf('<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle %s" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            %s
    </a>',$_Color,$_dropDownBtnArray[0][0]['listName']);
                echo sprintf('<ul class="dropdown-menu %s %s" aria-labelledby="navbarDropdown">',$_bgColor,$_Color);


//        <li><a class="dropdown-item" href="#">Action</a></li>
//        <li><hr class="dropdown-divider"></li>


            if(!empty($_dropDownBtnArray))
            {
                foreach ($_dropDownBtnArray as  $buttons)
                {
                    if(is_array($buttons))
                    {
                        foreach ($buttons as $btn)
                        {

                            echo sprintf('<li><a class="dropdown-item %s %s" href="%s">%s</a></li>',$_Color,$_bgColor,$btn['link'],$btn['title']);

                        }
                    }
                }
            }


        echo '</ul>
</li>';

               // NAVBAR DROPDOWN BUTTON LIST END

        }
        echo '</ul>';

    }









    public function end()
    {
        echo "</div></div></nav>";
    }


















}