<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="utf-8">
  <title>Hvala!</title>
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500&display=swap" rel="stylesheet">
  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css'>
  <script src="https://kit.fontawesome.com/f739741657.js" crossorigin="anonymous"></script>
</head>

<body style="background-color: #f7f7f7;">

  <div class="jumbotron text-xs-center" style="background-color: #f7f7f7;">
  <h1 class="display-3">Hvala vam na kupovini!</h1>
  <p class="lead">Vaša narudžba je zaprimljena i kroz par minuta ćete dobiti potvrdu na email adresu: <strong>{{ $email }}</strong></p>
  <hr>
  <!--<p>
    Niste dobili email? <a href="">Pošalji opet</a>
  </p>-->
  <p class="lead">
    <a class="btn btn-outline-primary btn-round" href="/editProfil">Povratak na stranicu <i class="fas fa-arrow-right"></i></a>
  </p>
</div>

  

</body>
<style>
body{
  font-family: 'Barlow Condensed', sans-serif;
}
</style>
</html>