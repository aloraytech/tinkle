<?php


namespace tinkle\framework\Library\Dictionary;


class Dictionary
{


    protected string $fileName;
    protected string $fileData;
    protected string $output;

    /**
     * Dictionary constructor.
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }



    public function check()
    {
        $this->output = $this->manipulateBadWords(file_get_contents($this->fileName));
    }




    public function get()
    {
        return $this->output;
    }











    private function manipulateBadWords(string $fileData)
    {
        $this->fileData = str_replace('fucker','f****r',$fileData);
        $this->fileData = str_replace('fuck','f**k',$this->fileData);
        $this->fileData = str_replace('sex','s**',$this->fileData);
        $this->fileData = str_replace('boob','b**b',$this->fileData);
        $this->fileData = str_replace('penis','p***s',$this->fileData);
        $this->fileData = str_replace('dick','d***',$this->fileData);
        $this->fileData = str_replace('pussy','p**s*',$this->fileData);
        $this->fileData = str_replace('cunt','c*n*',$this->fileData);
        $this->fileData = str_replace('nipple','n***le',$this->fileData);
        $this->fileData = str_replace('bitch','b**ch',$this->fileData);



        return $this->fileData;


    }





    private function getBadWords()
    {
        return ['fucker','fuck '];
    }





}