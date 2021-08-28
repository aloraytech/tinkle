<?php


namespace Tinkle\Designer\Form;
use Tinkle\Model;

class TextArea extends Fields
{
    private string $jid = '';


    public function __construct(Model $model, string $attribute,string $id='')
    {
        $this->jid = $id;
        parent::__construct($model, $attribute);
    }



    public function renderInput()
    {
        return sprintf('<textarea class="form-control%s" name="%s" id="%s" %s>%s</textarea>',
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,$this->getJid(),$this->fAttr,
            $this->model->{$this->attribute},
        );
    }


    private function getJid()
    {
        if(!empty($this->jid))
        {
            return $this->jid;
        }else{
            return $this->jid = $this->attribute.time();
        }
    }

}