{{extend('layout/bootstrap')}}
<?php
use tinkle\framework\Library\Designer\Designer;
use tinkle\app\models\UsersModel;

$model = new UsersModel();


Designer::$design->navbar()->start(Designer::COLOR_DARK,Designer::COLOR_DARK);
Designer::$design->navbar()->branding('/','Tinkle',Designer::TEXT.Designer::COLOR_LIGHT);
Designer::$design->navbar()->generateButtons(Designer::TEXT.Designer::COLOR_LIGHT,Designer::BACKGROUND.Designer::COLOR_PRIMARY,[
        Designer::$design->navbar()->buildButton('link/to/1','LinkOne',true),
    Designer::$design->navbar()->buildButton('link/to/2','LinkTwo'),
    Designer::$design->navbar()->buildButton('link/to/3','LinkThree'),
    Designer::$design->navbar()->buildButton('link/to/4','LinkFour'),
],[
        Designer::$design->navbar()->buildDropDownButton('Service','droptodown/1','DropOne'),
    Designer::$design->navbar()->buildDropDownButton('Service','droptodown/2','DropTwo'),
    Designer::$design->navbar()->buildDropDownButton('Service','droptodown/3','DropThree'),
    Designer::$design->navbar()->buildDropDownButton('Service','droptodown/4','DropFour'),
]);

//Designer::$design->navbar()->search();
Designer::$design->navbar()->end();

Designer::$design->div()->start('card col-6');

Designer::$design->form()->start('','post');

echo  Designer::$design->form()->field($model,'username')->text();
echo  Designer::$design->form()->field($model,'email')->email();
echo  Designer::$design->form()->field($model,'password')->password()->required();
//echo  Designer::$design->form()->imageOrFile($model,'image')->accept('jpeg')->required();
echo  Designer::$design->form()->field($model,'passwordConfirm')->password()->required();
Designer::$design->form()->BtnSubmit();
Designer::$design->form()->end();


Designer::$design->div()->end();
?>
{{include('components/form')}}

I fuck you bitch, bite your boobs nipples, put my dick inside your pussy or cunt, play with boobs. I am a fucker,
