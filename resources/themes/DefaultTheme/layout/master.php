
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @PAGE_CSRF
    <!--      AUTOMATIC LOGOUT AFTER 6 SEC-->
    <!--      <meta http-equiv="refresh" content="6;url=/logout" />-->
    @PAGE_FAVICON
    @PAGE_CSS
    @PAGE_TITLE
</head>
<body>
<div class="container-fluid">
    <?php
    // Flash Success Message
    if (\Tinkle\Tinkle::$app->session->getFlash('success')) : ?>
        <div class="alert alert-success">
            <?php echo \Tinkle\Tinkle::$app->session->getFlash('success');  ?>
        </div>
    <?php endif;
    // Flash Success Message
    ?>
</div>

{{content}}

<!-- Optional JavaScript -->
@PAGE_JS
</body>
</html>
