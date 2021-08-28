<?php


namespace Tinkle\Library\Designer\Form;
use Tinkle\Database\Manager\DBManager;

class Inputs extends Fields
{

    const TYPE_TEXT = 'text';
    const TYPE_PASSWORD = 'password';
    const TYPE_EMAIL = 'email';
    const TYPE_HIDDEN = 'hidden';
    private string $jid = '';


    public function __construct(DBManager $model, string $attribute,string $id='')
    {
        $this->type = self::TYPE_TEXT;
        $this->jid = $id;
        parent::__construct($model, $attribute);
    }

    public function renderInput()
    {
        return sprintf('<input type="%s" class="form-control%s" name="%s" value="%s" id="%s" %s>',
            $this->type,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute},$this->getJid(),$this->fAttr,
        );
    }

    public function password()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }



    public function email()
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }

    public function text()
    {
        $this->type = self::TYPE_TEXT;
        return $this;
    }
    public function hidden()
    {
        $this->type = self::TYPE_HIDDEN;
        return $this;
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


    public function maxlength(int $length)
    {
        $this->fAttr .= 'maxlength="'.$length.'" ';
        return $this;
    }



}