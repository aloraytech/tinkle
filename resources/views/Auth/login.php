{{extend('layout/bootstrap')}}

<?php
use tinkle\app\models\UsersModel;
use tinkle\framework\Library\Designer\Designer;
//$model = new UsersModel();

Designer::$design->form()->start('/login','post');
echo Designer::$design->form()->field($model,'email')->email();
echo Designer::$design->form()->field($model,'password')->password();
//echo Designer::$design->form()->field($model,'passwordConfirm')->password();
echo Designer::$design->form()->BtnSubmit();
Designer::$design->form()->end();

?>
