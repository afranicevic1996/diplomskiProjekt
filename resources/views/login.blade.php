<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script src="https://kit.fontawesome.com/f739741657.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>

<div class="jumbotron">
  <div class="text-center text-light">
    <h1>eTrgovina</h1>      
    <p class="text-light">Želimo vam sretnu i sigurnu kupnju!</p>
  </div>
</div>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/">Početna <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/oNama">O nama</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/uvjetiKoristenja" tabindex="-1">Uvjeti poslovanja</a>
      </li>
    </ul>
    @if(!session()->has('username'))
      <a class="btn btn-outline-secondary btn-round" href="/login" role="button">Prijava</a>&nbsp;
      <a class="btn btn-outline-danger btn-round" href="/register" role="button">Registracija</a>
    @endif

    @if(session()->has('username'))
      <a class="btn btn-outline-secondary btn-round" href="/editProfil" role="button">Uredi profil (@if(session()->has('username')){{ session()->get('username') }}@endif)</a>&nbsp;
      <a class="btn btn-outline-danger btn-round" href="/logout" role="button">Odjava</a>
    @endif
  </div>
</nav>

<div class="container-fluid">
 <div class="row">
  <div class="col-lg-12">
      @if(session()->has('status'))
        @if(!session()->get('error'))
          <div class="alert alert-success" role="alert">
            <center>{{ session()->get('status') }}</center>
          </div>
        @else
          <div class="alert alert-danger" role="alert">
            <center>{{ session()->get('status') }}</center>
          </div>
        @endif
      @endif
  	  <center><legend>Prijavi se</legend></center>
      <hr>
    <div class="center">
      <form id="forma" method="POST" action="/login">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="username">Korisničko ime</label>
            <input id="username" name="username" type="text" placeholder="Korisničko ime" class="podaci form-control">
            <div class="invalid-feedback">
              Ovo polje ne smije biti prazno!
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" placeholder="Password" class="podaci form-control">
            <div class="invalid-feedback">
              Ovo polje ne smije biti prazno!
            </div>
          </div>
         </div>
        <button type="submit" id="save" name="save" class="btn btn-outline-primary">Prijava</button>
        <a class="btn btn-outline-secondary" id="resetPolja" href="#" role="button">Resetiraj polja</a>
      </form>
        <p>Zaboravljena lozinka? <a data-toggle="collapse" data-target="#demo" href="">Zatraži novu lozinku.</a></p>
        <div id="demo" class="collapse">
          <hr>
          <center>Upišite korisničko ime i email korisnika</center>
          <form id="formaReset" style="display: inline;" method="POST" action="/resetPassword">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-4">
               <input name="username" type="text" placeholder="Korisničko ime" class="podaciReset form-control" required>
               <div class="invalid-feedback">
                 Ovo polje ne smije biti prazno!
               </div>
              </div>
              <div class="form-group col-md-6">
               <input id="email" name="email" type="email" placeholder="Email" class="podaciReset form-control">
               <div class="invalid-feedback emailTxt">
                 Ovo polje ne smije biti prazno!
               </div> 
              </div>
              <div class="form-group col-md-2">
                <button type="submit" id="save" name="save" class="btn btn-outline-primary">Zatraži</button>
              </div>
            </div>
          </form>
        </div>

    </div>
    <br>
  </div>
 </div>
</div>




<!-- Footer -->
<footer class="navbar-fixed-bottom">

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2020 Copyright:
    <a href="https://mdbootstrap.com/"> MDBootstrap.com</a>
  </div>
  <!-- Copyright -->

</footer>
<!--
<div class="container">    
  <div class="row">

<form id="forma" class="form-horizontal" method="POST" action="/loginUser">
  @csrf
<fieldset>


<legend>Prijavite se</legend>

<div class="form-group">
  <label class="col-md-4 control-label" for="username">Korisničko ime</label>  
  <div class="col-md-4">
  <input id="username" name="username" type="text" placeholder="Korisničko ime" class="form-control input-md" required="">
    
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="password">Password</label>
  <div class="col-md-4">
    <input id="password" name="password" type="password" placeholder="Password" class="form-control input-md" required="">
    
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label" for="save"></label>
  <div class="col-md-8">
    <button id="save" name="save" class="btn btn-primary">Prijava</button>
    <a class="btn btn-danger" id="resetPolja" href="#" role="button">Resetiraj polja</a>
  </div>
</div>

</fieldset>
</form>

@if(!empty($check))
  @if($check == 1)
    <div class="alert alert-success" role="alert">
      <center>Registracija uspješna. Sada se možete prijaviti.</center>
    </div>
  @endif

  @if($check == 2)
    <div class="alert alert-danger" role="alert">
      <center>Neuspješna prijava. Korisničko ime ili password nisu točni.</center>
    </div>
  @endif
@endif

</div>
</div>
-->
</body>

<script>
  function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)) {
       return false;
    }else{
       return true;
    }
  }

  $(document).ready(function(){

    $(".emailTxt").text("Ovo polje ne smije biti prazno!");
    $("#formaReset").submit(function(e){
      var email = $("#email").val();
      if(!IsEmail(email)){
        $("#email").addClass("is-invalid");
        $(".emailTxt").text("Krivi format emaila!");
        e.preventDefault(e);
      }
    });

    $("#resetPolja").click(function(){
      $("form#forma .podaci").each(function(){
        var polje = $(this);
        polje.removeClass("is-valid");
        polje.removeClass("is-invalid");
        polje.val('');
      });
    });

    $("#save").click(function(e){
      $("form#forma .podaci").each(function(){
       var polje = $(this);

       if(polje.val() == '' || polje.val() == null){
        e.preventDefault();
        polje.removeClass("is-valid");
        polje.addClass("is-invalid");
       }else{
        polje.removeClass("is-invalid");
        polje.addClass("is-valid");
       }

      });
    }); 

    @if(session()->has('status'))
      setTimeout(function() {
      $('.alert').fadeOut('slow');
    }, 5000);
    @endif
  });
</script>
  <style>
body{
  font-family: 'Barlow Condensed', sans-serif;
}

    /* Remove the navbar's default rounded borders and increase the bottom margin */ 
    .navbar {
      margin-bottom: 50px;
      border-radius: 0;
    }

    a:hover {text-decoration: none;}
    
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
      margin-bottom: 0;
    }
   
    /* Add a gray background color and some padding to the footer */
  footer{
    position: absolute;
    bottom: 0;
    width: 100%;
    background-color: #292b2c;
  }

    .jumbotron {
      background: url("{{ URL::asset('shop.jpg') }}") no-repeat;
    }

   .center{
    width: 500px;
    margin-left: auto;
    margin-right: auto;
}
  </style>
</html>