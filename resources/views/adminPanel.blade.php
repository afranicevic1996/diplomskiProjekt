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
        <a href="/adminPanel" class="list-group-item list-group-item-action active">Korisnički računi</a>
        <a href="/adminPanel/addAdminUser" class="list-group-item list-group-item-action">Kreiraj admin korisnika</a>
        <a href="/adminPanel/addProduct" class="list-group-item list-group-item-action">Kreiraj proizvod</a>
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
      
      <center><legend>Popis svih korisničkih računa</legend></center><br>
      <table class="table table-hover shopping-cart-wrap">
      <thead class="text-muted">
      <tr>
        <th scope="col" width="170">Korisnik</th>
        <th scope="col" width="170">Ime</th>
        <th scope="col" width="210">Prezime</th>
        <th scope="col" width="270">Email</th>
        <th scope="col" width="160">Telefon</th>
        <th scope="col" width="270">Adresa</th>
        <th scope="col" width="180">Poštanski broj</th>
        <th scope="col" class="text-right">Akcije</th>
      </tr>
      </thead>
      <tbody>
      @foreach($users as $user)
      <tr>
        <form id="formaUpdate{{ $user->id }}" action="/updateUser" method="post">
        @csrf
        <input type="hidden" id="" name="id" value="{{ $user->id }}">
        <td>
          <input type="text" id="" name="username" value="{{ $user->username }}" placeholder="Korisnik" class="form-control"> 
        </td>
        <td>
          <input type="text" id="" name="ime" value="{{ $user->ime }}" placeholder="Ime" class="form-control">
        </td>
        <td>
          <input type="text" id="" name="prezime" value="{{ $user->prezime }}" placeholder="Prezime" class="form-control">
        </td>
        <td> 
          <input type="text" id="" name="email" value="{{ $user->email }}" placeholder="Email" class="form-control">
        </td>
        <td> 
          <input id="" name="telefon" type="number" min="0" oninput="validity.valid||(value='');" value="{{ $user->telefon }}" placeholder="Telefon" class="form-control">
        </td>
        <td> 
          <input type="text" id="" name="adresa" value="{{ $user->adresa }}" placeholder="Adresa" class="form-control">
        </td>
        <td> 
          <input id="" name="pbroj" type="number" min="0" oninput="validity.valid||(value='');" value="{{ $user->pbroj }}" placeholder="Poštanski broj" class="form-control">
        </td>
        <td class="text-right">
          <button type="button" data-toggle="modal" data-target="#exampleModal" data-akcija="update" data-user="{{ $user->id }}" class="btn btn-outline-success btn-round"> <i class="far fa-save"></i></a></button>
          </form>
          <form id="formaDel{{ $user->id }}" style="display: inline;" action="/deleteUser" method="post">
            @csrf
            <input type="hidden" id="" name="id" value="{{ $user->id }}">
            <button type="button" data-toggle="modal" data-target="#exampleModal" data-akcija="delete" data-user="{{ $user->id }}" class="btn btn-outline-danger btn-round"> </i><i class="far fa-trash-alt"></i></button>
          </form>
        </td>
      </tr>
      @endforeach
      </tbody>
      </table>
      <hr>
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Upozorenje!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Jeste li sigurni da želite <span class="akcija"></span> ovog korisnika (id: <span id="idKor"></span>) ?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary btn-round" data-dismiss="modal">Prekini</button>
              <button id="akcija" type="button" class="btn btn-round"></button>
            </div>
          </div>
        </div>
      </div>

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

    $('#exampleModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var userID = button.data('user'); // Extract info from data-* attributes
      var akcija = button.data('akcija');
      var modal = $(this);

      if(akcija == "update"){
        modal.find('.akcija').text('urediti');
        $("#akcija").removeClass("btn-outline-danger");
        $("#akcija").addClass("btn-outline-success");
        $("#akcija").html("Uredi");
      }

      if(akcija == "delete"){
        modal.find('.akcija').text('izbrisati');
        $("#akcija").removeClass("btn-outline-success");
        $("#akcija").addClass("btn-outline-danger");
        $("#akcija").html("Izbriši");
      }

      modal.find('.modal-title').text('Upozorenje!');
      //modal.find('.modal-body input').val(recipient);
      modal.find('#idKor').text(userID);

      $("#akcija").click(function(){
        if(akcija == "delete"){
          $("#formaDel"+userID).submit();
        }

        if(akcija == "update"){
          $("#formaUpdate"+userID).submit();
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

.col-lg-4{
  background-color: red;
}

.fa-star{
  font-size: 12px;
}

.checked {
  color: orange;
}
    .navbar {
      margin-bottom: 50px;
      border-radius: 0;
    }

    a:hover {text-decoration: none;}
    
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
      margin-bottom: 0;
    }
   

    .jumbotron {
      background: url("{{ URL::asset('shop.jpg') }}") no-repeat;
    }

.carousel-inner{
  width:100%;
  max-height: 600px !important;
}

.carousel-control-next-icon,
.carousel-control-prev-icon {
  filter: invert(1);
}

.blue{
  background-color: #292b2c;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
</html>
