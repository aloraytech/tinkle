<?php


namespace Tinkle;

use Tinkle\Library\Http\RequestHandler;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class Request extends RequestHandler
{
    /**
     * @var mixed|null
     */
    private array $FileData;
    private object $FileObject;


    /**
     * Request constructor.
     */
    public function __construct()
    {

        parent::__construct();
    }






    /**
     * @return array
     * Get Html Body Content Basically Post And Get Params..And Sanetize them here
     */
    public function getAllContent()
    {
        $data = [];
        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $data;
    }





    // FILES AND FOLDER RELATED METHODS

    public function prepareUpload(string $filename)
    {
        if(is_string($filename))
        {

            if($this->postHasFiles())
            {

                $file = $this->getRequestFileObject($filename);
                $this->FileObject = $file;
                $file_data = getimagesize($_FILES[$filename]['tmp_name']);
                if(is_array($file_data))
                {
                    $this->FileData = $file_data;
                }else{
                    return false;
                }







                // Note mime type and guessExtension not working due to symfony/mime package
                    $data [$filename]['details'] = [
                        'name' => $this->FileObject->getClientOriginalName(),
                        'ext' => $this->FileObject->getClientOriginalExtension(),
                        'error'=> $this->FileObject->getError(),
                        'valid'=>$this->FileObject->isValid(),
                        'type'=> $this->FileObject->getClientMimeType(),
                        'size'=> $_FILES[$filename]['size'],
                        'hash'=> password_hash(strtolower($this->FileObject->getClientOriginalName().random_bytes(16)).time(),1).'.'.$file->getClientOriginalExtension(),
                        'width'=> $this->FileData[0],
                        'height'=> $this->FileData[1],
                        //'channels' => $this->FileData['channels'],
                        'bits' => $this->FileData['bits']
                    ];
                    $data [$filename]['raw'] = [
                        'name'=> $_FILES[$filename]['name'],
                        'type'=> $_FILES[$filename]['type'],
                        'tmp'=> $_FILES[$filename]['tmp_name'],
                        'error'=> $_FILES[$filename]['error'],
                        'size'=> $_FILES[$filename]['size'],
                    ];

                    // Security Purpose
                $data [$filename]['security'] = [
                    'ext' => $this->FileObject->getClientOriginalExtension(),
                    'error'=> $this->FileObject->getError(),
                    'valid'=>$this->FileObject->isValid(),
                    'hash'=>$data [$filename]['details']['hash'],
                    'tmp'=> $_FILES[$filename]['tmp_name'],
                ];

                $data [$filename]['security']['alarm'] = 0;
                if(count(explode(".",$this->FileObject->getClientOriginalName())) !=2)
                {
                    $data [$filename]['security']['alarm'] = 1;
                }

                $subject = file_get_contents($_FILES[$filename]['tmp_name']);
                if(preg_match_all('/\<\?/',$subject,$matches))
                {
                    $data [$filename]['security']['alarm'] += 1;
                    // Check If File is Php
                    if(!empty($matches))
                    {
                        if(preg_match_all('/\>\?/',$subject,$matches))
                        {
                            $data [$filename]['security']['real'] = 'php';
                        }
                    }
                }elseif(preg_match_all('/php/',$subject,$matches))
                {
                    $data [$filename]['security']['alarm'] += 1;
                    $data [$filename]['security']['real'] = 'php';
                }elseif(preg_match_all('/class/',$subject,$matches))
                {
                    $data [$filename]['security']['alarm'] += 1;
                    $data [$filename]['security']['real'] = 'invalid';
                }elseif(preg_match_all('/function/',$subject,$matches))
                {
                    $data [$filename]['security']['alarm'] += 1;
                    $data [$filename]['security']['real'] = 'invalid';
                }elseif(preg_match_all('/exec/',$subject,$matches))
                {
                    $data [$filename]['security']['alarm'] += 1;
                    $data [$filename]['security']['real'] = 'invalid';
                }elseif(preg_match_all('/public/',$subject,$matches))
                {
                    $data [$filename]['security']['alarm'] += 1;
                    $data [$filename]['security']['real'] = 'invalid';
                }

                return $data[$filename];
            }
            return false;
        }
        return false;
    }



    public function upload(array $image,string $target)
    {
        if(!is_array($image) && !is_string($target))
        {
            return false;
        }else{

            $path = Tinkle::$ROOT_DIR.'/'.$_SERVER['UPLOAD_DIR'].'/'.$target;
            if($image['details']['valid'] ==1 && $image['details']['error'] ==0 && $image['security']['alarm'] ==0)
            {
                if($this->FileObject->move($path,$image['details']['hash']))
                {
                   return true;
                }
            }else{
                return false;
            }
            return false;
        }
    }





    public function prepareLoadDataWithUpload(array $data,array $upload)
    {

    }







}