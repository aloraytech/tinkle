<?php
use tinkle\framework\Tinkle;
?>

{{extend('layout/bootstrap')}}

<ul>

<?php if(Tinkle::isGuest()):  ?>
    <li class="nav-item ">
        <a class="nav-link" href="/login">Login <span class="sr-only">(current)</span></a>
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="/register">Register <span class="sr-only">(current)</span></a>
    </li>

<?php else: ?>

    <li class="nav-item ">
        <a class="nav-link" href="/profile">Profile</a>
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="/logout">Welcome <?php echo Tinkle::$app->user->getDisplayName() ?> (Logout) </a>
    </li>

<?php endif; ?>
</ul>


<div>
    <?php
    // Flash Success Message
    if (Tinkle::$app->session->getFlash('success')) : ?>
        <div class="alert alert-success">
            <?php echo Tinkle::$app->session->getFlash('success');  ?>
        </div>
    <?php endif;
    // Flash Success Message
    ?>
</div>

<div>
    <img class="img-fluid" src="{{assets('resources/upload/example.png')}}" width="250px">
</div>

<button class="tinkle-btn-rounded">My Button</button>
