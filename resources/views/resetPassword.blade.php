<!DOCTYPE html>
<html lang="en">
<head>
  <title>Reset</title>
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

<div class="container">
 <div class="row">
  <div class="col-lg-12">
    <div class="center">
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

      <center>Unesite kod za povrat zaporke sa vašeg emaila: <b>{{ $email }}</b></center>
      <form id="resetPassword" style="display: inline;" method="POST" action="/checkKod">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-3">
            <input type="text" name="username" placeholder="Korisničko ime" value="{{ $username }}" id="username" class="podaci form-control" required>
          </div>

          <div class="form-group col-md-3">
            <input type="email" name="email" placeholder="Email" value="{{ $email }}" id="email" class="podaci form-control" required>
          </div>

          <div class="form-group col-md-3">
            <input name="kod" id="kod" type="text" placeholder="Unesite kod" class="podaci form-control" required>
          </div>

          <div class="form-group col-md-3">
            <button type="submit" class="btn btn-outline-primary check">Pošalji</button>
          </div>
        </div>
      </form>
      <div id="rezultat">
      </div>

    </div>
  </div>
 </div>
</div>

</body>
<script>
  $(document).ready(function(){

    @if(session()->has('status'))
      setTimeout(function() {
      $('.alert').fadeOut('slow');
    }, 5000);
    @endif

    $(".check").click(function(){

      $("#resetPassword").submit(function(e){
          e.preventDefault(e);
      });

      $("#rezultat").empty();
      var username = $("#username").val();
      var kod = $("#kod").val();
      var email = $("#email").val();
      var podaci = $('#resetPassword').serialize();

      request = $.ajax({
        url: "/checkKod",
        type: "POST",
        data: podaci
      });

      request.done(function (response, textStatus, jqXHR){
        data = JSON.parse(response);
        if(data.status == -1){
          $("#rezultat").append("Dogodila se greška!");
        }

        if(data.status == 0){
          $("#rezultat").append("Unijeli ste krivi ili već iskorišteni kod!");
        }

        if(data.status == 1){
          var htmlTekst = "<hr><form id='changePassword' method='post' action='/changePassword'><input name='_token' value='{{ csrf_token() }}' type='hidden'><input type='hidden' name='email' class='podaci' value='"+email+"'><input type='hidden' name='kod' class='podaci' value='"+kod+"'><input type='hidden' name='username' class='podaci' value='"+username+"'><input type='text' id='password' name='password' placeholder='Upišite novi password' class='form-control' required><div class='invalid-feedback'></div><br><input type='text' id='password2' name='password2' placeholder='Potvrdite novi password' class='form-control' required><div class='invalid-feedback'></div></form><button id='potvrdi' type='submit' class='btn btn-outline-primary'>Pošalji</button>";

          $("#rezultat").append(htmlTekst);
        }

      });

    });

    $(document).on("click", '#potvrdi', function(){
      $("#password").removeClass("is-invalid");
      $("#password2").removeClass("is-invalid");
      $(".invalid-feedback").text("");
      if($("#password").val() != $("#password2").val() || $("#password").val() == '' || $("#password2").val() == ''){
        $("#password").addClass("is-invalid");
        $("#password2").addClass("is-invalid");
        $(".invalid-feedback").text("Passwordi nisu isti ili niste popunili sva polja");

        /*$("#changePassword").submit(function(e){
          e.preventDefault();
        });*/
      }else{
        $("#changePassword").submit();
      }
    });

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
    width: 700px;
    margin-left: auto;
    margin-right: auto;
}
  </style>
</html>