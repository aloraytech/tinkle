{{extend('layout/bootstrap')}}
<?php
echo $name;
?>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Offcanvas right</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        ...
    </div>
</div>


<div class="card">
    <div class="card-header">{{code('$name')}}</div>
    <div class="card-body">
        Name : {{code('$name')}} <br>
        Age : {{code('$age')}} <br>
        Including Result: <br>
        {{include('components/form')}}
    </div>
</div>

{{code('$color[0]')}}

{{include('hello/go')}}

{{include('components/form')}}