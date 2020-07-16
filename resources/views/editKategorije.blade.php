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
        <a href="/adminPanel/addProduct" class="list-group-item list-group-item-action">Kreiraj proizvod</a>
        <a href="/adminPanel/editProducts" class="list-group-item list-group-item-action">Uredi proizvod</a>
        <a href="/adminPanel/editKategorije" class="list-group-item list-group-item-action active">Uredi kategorije</a>
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

      <div class="deleteFormeDiv">
        @foreach($kategorije as $kate)
         <form id="formaDel{{ $kate->id }}" style="display: inline;" action="/adminPanel/editKategorije" method="post">@csrf @method("DELETE")
            <input type="hidden" id="" name="id" value="{{ $kate->id }}"> 
         </form>
        @endforeach
      </div>

      <div class="updateFormeDiv">
        @foreach($kategorije as $kate)
          <form id="formaUpdate{{ $kate->id }}" action="/adminPanel/editKategorije" method="post">@csrf @method("POST")
          </form>
        @endforeach
      </div>

      <center><legend>Popis svih kategorija</legend></center><hr>
      <table class="table center table-hover shopping-cart-wrap">
        <thead class="text-muted">
        <tr>
          <th scope="col" width="100">ID</th>
          <th scope="col" width="250">Naziv</th>
          <th scope="col" class="text-right">Akcije</th>
        </tr>
        </thead>
      <tbody>
      @foreach($kategorije as $kate)
      <tr>
        <td>
          <input type="hidden" id="" name="id" form="formaUpdate{{ $kate->id }}" value="{{ $kate->id }}" placeholder="Korisnik" class="form-control">
          <b>{{ $kate->id }}</b> 
        </td>
        <td>
          <input type="text" id="" form="formaUpdate{{ $kate->id }}" name="naziv" value="{{ $kate->naziv }}" placeholder="Naziv" class="form-control" required>
        </td>
        <td class="text-right">
          <button type="button" data-toggle="modal" data-target="#exampleModal" data-akcija="update" data-user="{{ $kate->id }}" class="btn btn-outline-success btn-round"> <i class="far fa-save"></i></a></button>
          <button type="button" data-toggle="modal" data-target="#exampleModal" data-akcija="delete" data-user="{{ $kate->id }}" class="btn btn-outline-danger btn-round"> </i><i class="far fa-trash-alt"></i></button>
        </td>
      </tr>
      @endforeach
      <tr>
        <td></td>
        <td>
          <b>Kreiraj novu kategoriju</b>
        </td>
        <td class="text-right">
          <button type="button" data-target="#collapseExample" aria-expanded="false" data-toggle="collapse" aria-controls="collapseExample" class="btn btn-outline-success btn-round"> <i class="fas fa-plus-circle"></i></i></button>
        </td>
      </tr>

      <tr class="collapse" id="collapseExample">
        <td colspan="3">
        <div class="card card-body">
          <form method="post" id="forma" action="/adminPanel/editKategorije">
            @csrf
            @method("PUT")
            <div class="form-group">
              <label for="naziv">Naziv</label>
              <input id="naziv" name="naziv" type="text" placeholder="Naziv kategorije" class="podaci form-control">
              <div class="invalid-feedback">
                Ovo polje ne smije biti prazno!
              </div>

            <label for="komponenta">Odaberi</label>
            <select name="komponenta" class="podaci browser-default custom-select" required>
              <option value="" disabled selected>Izaberi da li je kategorija komponenta računala</option>
              <option value="1">Da</option>
              <option value="0">Ne</option>
            </select>
              <div class="invalid-feedback">
                Ovo polje ne smije biti prazno!
              </div>

            </div>
            <button id="save" class="btn btn-outline-primary btn-round">Kreiraj</button>
          </form>
        </div>
        </td>
      </tr>
      </tbody>
      </table>
      <hr><br><br>
      <!-- modal -->
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
              Jeste li sigurni da želite <span class="akcija"></span> ovu kategoriju (id: <span id="idKor"></span>) ?
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
<script type="text/javascript">

  $(document).ready(function(){
    @if(session()->has('status'))
      setTimeout(function() {
      $('.alert').fadeOut('slow');
    }, 5000);
    @endif

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
        polje.next(".invalid-feedback").text("");
       }

      });
    });

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

.center{
    width: 600px;
    margin-left: auto;
    margin-right: auto;
}
</style>
</html>