<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin panel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script src="https://kit.fontawesome.com/f739741657.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</head>
<body>

<div class="jumbotron">
  <div class="text-center text-light">
    <h1>eTrgovina</h1>      
    <p class="text-light">Admin panel</p>
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
      <a class="btn btn-outline-secondary btn-round" href="/adminPanel" role="button">Admin panel</a>&nbsp;
      <a class="btn btn-outline-danger btn-round" href="/logout" role="button">Odjava</a>
  </div>
</nav>

<div class="container-fluid">    
  <div class="row">

    <div class="col-lg-2">
      <div class="list-group">
        <a href="" class="list-group-item list-group-item-dark inactiveLink">Prijavljeni ste kao: {{ session()->get('username') }}</a>
        <a href="/adminPanel" class="list-group-item list-group-item-action">Korisnički računi</a>
        <a href="/adminPanel/addAdminUser" class="list-group-item list-group-item-action">Kreiraj admin korisnika</a>
        <a href="/adminPanel/addProduct" class="list-group-item list-group-item-action active">Kreiraj proizvod</a>
        <a href="/adminPanel/editProducts" class="list-group-item list-group-item-action">Uredi proizvod</a>
        <a href="/adminPanel/editKategorije" class="list-group-item list-group-item-action">Uredi kategorije</a>
        <a href="/adminPanel/posebneAkcije" class="list-group-item list-group-item-action">Uredi posebne akcije</a>
      </div>
    </div>

    <div class="col-lg-10"><!-- col-lg-10 -->
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
      
      <center><legend>Kreiraj novi proizvod</legend></center>
      <hr>
      <form id="forma" enctype="multipart/form-data" method="POST" action="/adminPanel/addProduct">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="ime">Naziv</label>
            <input id="ime" name="ime" type="text" value="" placeholder="Ime" class="podaci form-control">
            <div class='invalid-feedback'>
              Ovo polje ne smije biti prazno!
            </div>
          </div>
          <div class="form-group col-md-4">
            <label for="cijena">Cijena</label>
            <input id="cijena" name="cijena" type="text" value="" placeholder="Cijena" class="float podaci form-control">
            <div class="invalid-feedback">
              Ovo polje ne smije biti prazno!
            </div>
          </div>
          <div class="form-group col-md-2">
            <label for="dostupnost">Dostupnost</label>
            <select name="dostupnost" class="podaci browser-default custom-select" required>
              <option value="" disabled selected>Izaberi dostupnost</option>
              <option value="1">Dostupno</option>
              <option value="0">Nedostupno</option>
            </select>
            <div class="invalid-feedback">
              Ovo polje ne smije biti prazno!
            </div>
          </div>
          <div class="form-group col-md-2">
            <label for="kategorija">Kategorija</label>
            <select name="kategorija" class="podaci browser-default custom-select" required>
              <option value="" disabled selected>Izaberi kategoriju</option>
              @foreach($kategorije as $kat)
                <option value="{{ $kat->id }}">{{ $kat->naziv }}</option>
              @endforeach
            </select>
            <div class="invalid-feedback">
              Ovo polje ne smije biti prazno!
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="opis">Opis proizvoda</label>
            <textarea id="opis" name="opis" class="podaci form-control" rows="3"></textarea>
            <div class="invalid-feedback">
              Ovo polje ne smije biti prazno!
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="exampleFormControlFile1">Izaberite slike za proizvod</label>
            <input type="file" name="slike[]" class="podaci form-control-file" id="exampleFormControlFile1" multiple>
            <div class="invalid-feedback">
              Ovo polje ne smije biti prazno!
            </div>
          </div>
        </div>
        <button type="submit" id="save" name="save" class="btn btn-outline-primary">Kreiraj</button>
        <a class="btn btn-outline-secondary" id="resetPolja" href="#" role="button">Resetiraj polja</a>
      </form>
      <hr>
    </div><!-- col-lg-10 -->

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

    $('.float').keypress(function(e) {
      if ((e.which != 46 || $(this).val().indexOf('.') != -1) && (e.which < 48 || e.which > 57)) {
        e.preventDefault();
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

  });
</script>
<style>
body{
  font-family: 'Barlow Condensed', sans-serif;
}

.list-group-item-dark{
  background-color: #ECECEC;
}

.inactiveLink {
   pointer-events: none;
   cursor: default;
}

    .navbar {
      margin-bottom: 50px;
      border-radius: 0;
    }
    
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
      margin-bottom: 0;
    }
   

    .jumbotron {
      background: url("{{ URL::asset('shop.jpg') }}") no-repeat;
    }

footer{
  background-color: #292b2c;
}
</style>
</html>

