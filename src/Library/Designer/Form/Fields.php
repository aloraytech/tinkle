<?php


namespace tinkle\framework\Library\Designer\Form;

use tinkle\framework\Database\Manager\DBManager;

abstract class Fields
{


    public DBManager $model;
    public string $attribute;
    public string $type;
    protected string $fAttr = '';


    public function __construct(DBManager $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString()
    {
        return sprintf('
            <div class="form-group">
                <label>%s</label>
                %s
                <div class="invalid-feedback">%s</div>
            </div>
',
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }

    abstract public function renderInput();



    public function autofocus()
    {
        $this->fAttr .= 'autofocus ';
        return $this;
    }

    public function readonly()
    {
        $this->fAttr .= 'readonly ';
        return $this;
    }

    public function disabled()
    {
        $this->fAttr .= 'disabled ';
        return $this;
    }

    public function required()
    {
        $this->fAttr .= 'required ';
        return $this;
    }



    public function placeholder(int $message)
    {
        $this->fAttr .= 'placeholder="'.$message.'" ';
        return $this;
    }




}