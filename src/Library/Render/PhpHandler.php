<?php


namespace Tinkle\Library\Render;


use Tinkle\interfaces\RenderHandlerInterface;
use Tinkle\Tinkle;

class PhpHandler implements RenderHandlerInterface
{

    public string $layout='';
    public string $template='';
    private string $tempTemplate='';
    public array $param=[];
    protected array $defaultLayoutList = ['tinkle','main','','default','Tinkle','TINKLE'];
    protected string $ext = '.php';
    protected string $path = '';
    protected string $display='';
    public array $config=[];

    /**
     * PhpHandler constructor.
     * @param string $template
     * @param array $param
     * @param array $config
     */
    public function __construct(string $template,array $param=[],array $config)
    {
        $this->template = $template;
        $this->param = $param;
        $this->config = $config;
        $this->path = $this->config['path'];
        $this->tempTemplate = $this->template;

    }


    /**
     * @return bool
     */
    public function resolve(): bool
    {
        if($this->updateTemplateWithLayout())
        {
            return true;
        }else{
            return false;
        }

    }


    /**
     * @return mixed
     */
    public function display()
    {

        $_n_a_me = str_replace("/",'-',$this->config['url']);
        $_file_name = str_replace('/','.',$this->tempTemplate);
        extract($this->param);
        ob_start();
        require_once "$this->display";
        $html = Tinkle::$ROOT_DIR."storage/views/".$_n_a_me."-".$_file_name.".html";
        file_put_contents($html, ob_get_clean());

        @unlink($this->display);
        Tinkle::$app->session->set('tinkle_rendering',$html);
        Tinkle::$app->session->set('tinkle_rendering_time',time());
        // Returning Html File
        return  "$html";
        //return $this->display;
    }



    // Other Functions


    /**
     * @return bool
     */
    private function updateTemplateWithLayout()
    {
        $this->template = @file_get_contents($this->path.$this->template.$this->ext);
        if(!empty($this->template))
        {
            // Get Layout From Template File {{extend('layout/layoutName')}}
            $this->layout = $this->getLayoutFromTemplate();
            if(!empty($this->layout))
            {
                $this->layout = $this->updateAssetsTag($this->layout);
                $this->layout = $this->updateUrlTag($this->layout);
            }


            if(!is_null($this->template))
            {
                $this->template = $this->updateIncludeTag($this->template);
                $this->template = $this->updateCodeTag($this->template);
                $this->template = $this->updateAssetsTag($this->template);
                $this->template = $this->updateUrlTag($this->template);
                $this->template = $this->updateExtendTag($this->template);

            }


            // Update Layout with Template
            $this->layout = str_replace("{{content}}",$this->template,$this->layout);
            if($this->setRunTimeName())
            {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }





    private function getLayoutFromTemplate()
    {
        // Check for extend keyword
        if(preg_match("/{{extend\(.+\}}/",$this->template,$matches))
        {
            if(preg_match('/^{{extend\(\'/',$matches[0],$startBlock) && preg_match('/\'\)}}$/',$matches[0],$endBlock))
            {
                // get the layout name
                $givenLayoutName = str_replace("')}}","",str_replace("{{extend('","",$matches[0]));
                $givenLayout = $this->path.$givenLayoutName.$this->ext;
                // we get layout and load layout details
                if(file_exists($givenLayout) && is_readable($givenLayout))
                {
                    return $this->layout = @file_get_contents($givenLayout);
                }else{
                    echo "Layout Not Found - $givenLayoutName";
                    return $this->layout;
                }
                //$this->template = str_replace("$matches[0]","",$this->template);
            }elseif(preg_match('/^{{extend\("/',$matches[0],$startBlock) && preg_match('/"\)}}$/',$matches[0],$endBlock))
            {
                // get the layout name
                $givenLayoutName = str_replace('")}}','',str_replace('{{extend("','',$matches[0]));
                $givenLayout = $this->path.$givenLayoutName.$this->ext;
                // we get layout and load layout details
                if(file_exists($givenLayout) && is_readable($givenLayout))
                {
                    return $this->layout = @file_get_contents($givenLayout);
                }else{
                    echo "Layout Not Found :- $givenLayoutName";
                    return $this->layout;
                }

                //$this->template = str_replace("$matches[0]","",$this->template);
            }else{
                echo "Typo found, only {{extend('layout/myLayout')}} allowed with no file extension like .php, .html";
                return $this->layout;
            }


        }else{
            echo "Typo found, only {{extend('')}} allowed with no file extension";
            return $this->layout;
        }
    }




    private function updateUrlTag(string $fileName)
    {

        if(preg_match_all('/{{url\(.+\}}/',"$fileName",$matching))
        {
            foreach($matching as $key => $value)
            {
                if(is_array($value))
                {
                    foreach ($value as $link)
                    {
                        $given = str_replace("')}}","",str_replace("{{url('",'',$link));
                        $replacement = $this->config['fullUrl'].'/'.$given;
                        // Finally update Url link to absolute link for our output html
                        $fileName = str_replace($link,$replacement,$fileName);
                    }
                }
            }
        }
        return $fileName;
    }


    private function updateAssetsTag(string $fileName)
    {
        if(preg_match_all('/{{assets\(.+\}}/',"$fileName",$matches))
        {
            foreach($matches as $key => $value)
            {
                if(is_array($value))
                {
                    foreach ($value as $link)
                    {
                        $given = str_replace("')}}","",str_replace("{{assets('",'',$link));
                        $replacement = $this->config['fullUrl'].'/'.$given;


                        // DEFAULT I SET HERE IMAGE MUST ENCODED INTO BASE64 FORMAT AND THAT'S ALSO SET IN OUR CSP SETTINGS
                        // IF YOU DON'T USE BASE64 ENCODED IMAGE YOU HAVE TO MODIFY TINKLE VIEW CSP DESCRIPTION
                        // If Asset Is An Image; We Convert Into Base64 Encoded Image;
                        $imgInfo = pathinfo($replacement);
                        $imgData = @file_get_contents($replacement);
                        $imgData = base64_encode($imgData);
                        $format = 'data:image/' . $imgInfo['extension'] . ';charset=utf-8;base64, '.$imgData;
                        // Now Only Takes Known Image Type And Apply Our Format..
                        if($imgInfo['extension'] === 'jpg' || $imgInfo['extension'] === 'jpeg' || $imgInfo['extension'] === 'png' || $imgInfo['extension'] === 'gif')
                        {
                            // Finally update assets link to base64 encoded for our output image
                            $fileName = str_replace($link,$format,$fileName);
                        }else{
                            // Finally update assets link to absolute link for our output html
                            $fileName = str_replace($link,$replacement,$fileName);
                        }




                    }
                }
            }
        }
        return $fileName;
    }






    /**
     * @param string $fileName
     * @return mixed|string
     */
    private function updateExtendTag(string $fileName)
    {

        if(preg_match("/{{extend\(.+\}}/",$fileName,$matches))
        {
            $fileName = str_replace("$matches[0]","",$this->template);
        }

        return $fileName;

    }



    private function updateIncludeTag(string $fileName)
    {
        if(preg_match_all('/{{include\(.+\}}/',"$fileName",$matching))
        {

            foreach($matching as $key => $value)
            {
                if(is_array($value))
                {

                    foreach ($value as $link)
                    {

                        $given = str_replace("')}}","",str_replace("{{include('",'',$link));
                        $givenFile = $this->path.$given.$this->ext ?? '';
                        if(file_exists($givenFile) && is_readable($givenFile))
                        {
                            // I assumed that, {{include('')}} never place inside php code block, always put after ?/>
                            extract($this->param);
                            ob_start();

                            require_once $givenFile;
                            $tmpFile = Tinkle::$ROOT_DIR."storage/runtime/temp.html";
                            file_put_contents($tmpFile, ob_get_clean());
                            $replacement = @file_get_contents($tmpFile);
                            $fileName = str_replace($link,$replacement,$fileName);
                            unlink($tmpFile);
                        }else{
                            if($this->config['env'])
                            {
                                // Production Mode
                                $fileName = str_replace($link,"",$fileName);
                            }else{
                                // Development Mode
                                $fileName = str_replace($link,"<mark><del>$given</del></mark>",$fileName);
                            }

                        }

                    }
                }
            }
        }

        return $fileName;
    }



    private function updateCodeTag(string $fileName)
    {
        if(preg_match_all('/{{code\(.+\}}/',"$fileName",$matching))
        {

            foreach($matching as $key => $value)
            {
                if(is_array($value))
                {

                    foreach ($value as $link)
                    {

                        $given = str_replace("')}}","",str_replace("{{code('",'',$link));
                        $block = '<'."?php echo ".$given."; ?".'>';
                        $givenFile = Tinkle::$ROOT_DIR."storage/runtime/".$given.$this->ext ?? '';
                        $handler = fopen($givenFile,'w+');
                        fwrite($handler,$block);
                        fclose($handler);
                        if(file_exists($givenFile) && is_readable($givenFile))
                        {
                            extract($this->param);
                            // I assumed that, {{include('')}} never place inside php code block, always put after ?/>
                            ob_start();

                            require_once $givenFile;
                            $tmpFile = Tinkle::$ROOT_DIR."storage/runtime/temp.html";
                            file_put_contents($tmpFile, ob_get_clean());
                            $replacement = @file_get_contents($tmpFile);
                            $fileName = str_replace($link,$replacement,$fileName);
                            unlink($tmpFile);
                            unlink($givenFile);
                        }else{
//                            if($this->config['env'])
//                            {
//                                // Production Mode
//                                $this->template = str_replace($link,"",$this->template);
//                            }else{
//                                // Development Mode
//                                $this->template = str_replace($link,"<mark><del>$given</del></mark>",$this->template);
//                            }

                        }

                    }
                }
            }
        }

        return $fileName;
    }








    /**
     * @return mixed
     */
    private function setRunTimeName()
    {

        $subject =$this->config['url']?? 'landing';
        $tempFileName = str_replace("/","",$subject."-".$this->tempTemplate);

        $this->display = Tinkle::$ROOT_DIR."storage/runtime/".$tempFileName.$this->ext;
//        $tempFile = fopen($this->display,"w+");
//        fwrite($tempFile,$this->layout);
//        fclose($tempFile);
        file_put_contents($this->display,$this->layout);
        return true;



    }















    // Class End

}