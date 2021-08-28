
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      @PAGE_CSRF
<!--      AUTOMATIC LOGOUT AFTER 6 SEC-->
<!--      <meta http-equiv="refresh" content="6;url=/logout" />-->

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="{{assets('assets/bootstrap/b5/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{assets('assets/bootstrap/b5/css/sidebars.css')}}">
    <link rel="stylesheet" href="{{assets('assets/animate.css/animate.min.css')}}">
    <link rel="stylesheet" href="{{assets('assets/custom/css/style.css')}}">


    <title>Hello, world!</title>
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
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{assets('bootstrap/js/jquery.slim.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="{{assets('assets/bootstrap/b5/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{assets('assets/bootstrap/b5/js/sidebars.js')}}"></script>
  </body>
</html>
