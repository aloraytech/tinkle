{{extend('layout/bootstrap')}}
<?php
use tinkle\framework\Library\Designer\Designer;
use tinkle\app\models\UsersModel;

$model = new UsersModel();


Designer::$design->navbar()->start(Designer::COLOR_LIGHT,Designer::COLOR_PRIMARY);
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


Designer::$design->navbar()->end();

Designer::$design->div()->start();

Designer::$design->form()->start('/','post');

echo  Designer::$design->form()->field($model,'username')->text();
echo  Designer::$design->form()->field($model,'email')->email();
echo  Designer::$design->form()->field($model,'password')->password()->required();
echo  Designer::$design->form()->imageOrFile($model,'image')->accept('jpeg')->required();


Designer::$design->form()->end();


Designer::$design->div()->end();
?>
{{include('components/form')}}



<button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Toggle right offcanvas</button>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Offcanvas right</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        ...
    </div>
</div>
