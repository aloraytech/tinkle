<?php


namespace Tinkle\Library\Designer\Form;


use Tinkle\Databases\Manager\DBManager;

class FileField extends Fields
{
    const TYPE_FILE = 'file';
    const TYPE_IMAGE = 'image';
    private string $accept = '';
    private string $jid = '';

    public function __construct(DBManager $model, string $attribute,string $id='')
    {
        $this->type = self::TYPE_IMAGE;
        $this->jid = $id;
        parent::__construct($model, $attribute);
    }


    public function renderInput()
    {
        return sprintf('<input type="%s" class="form-control%s" name="%s" value="%s" accept="%s" id="%s" %s>',
            $this->type,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute},$this->accept,$this->getJid(),$this->fAttr,
        );
    }




    public function accept(string $type='')
    {
        $this->type = self::TYPE_FILE;
        $this->setAccept($type);
        return $this;
    }

    /**
     * @return string
     */
    private function getAccept(): string
    {
        return $this->accept;
    }

    /**
     * @param string $accept
     */
    private function setAccept(string $accept=''): void
    {

        switch (strtolower($accept)) {
            case "pdf":
                $this->accept = 'application/pdf';
                break;
            case "zip":
                $this->accept = 'application/zip';
                break;
            case "jpeg":
                $this->accept = 'image/jpeg';
                break;
            case "png":
                $this->accept = 'image/png';
                break;
            default:
                $this->accept = $accept;
        }

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