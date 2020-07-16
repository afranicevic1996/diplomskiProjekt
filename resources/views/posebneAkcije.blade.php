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
        <a href="/adminPanel/editKategorije" class="list-group-item list-group-item-action">Uredi kategorije</a>
        <a href="/adminPanel/posebneAkcije" class="list-group-item list-group-item-action active">Uredi posebne akcije</a>
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
        @foreach($akcije as $akcija)
         <form id="formaDel{{ $akcija->productID }}" style="display: inline;" action="/adminPanel/posebneAkcije" method="post">@csrf @method("DELETE")
            <input type="hidden" id="" name="productID" value="{{ $akcija->productID }}"> 
         </form>
        @endforeach
      </div>

      <center><legend>Popis posebnih akcija na proizvode</legend></center><hr>
      <table class="table center table-hover shopping-cart-wrap">
      <thead class="text-muted">
      <tr>
        <th scope="col" width="300">Slika</th>
        <th scope="col">Akcija za proizvod</th>
        <th scope="col">Promijeni sliku</th>
        <th scope="col" class="text-right">Akcije</th>
      </tr>
      </thead>
      <tbody>
      @foreach($akcije as $akcija)
      <?php $link = URL::asset($akcija->fileName); ?>
      	<tr>
      		<td><img src='{{ $link }}' class="d-block w-100" alt="..."></td>
      		<td><a class="link" href='/product/{{ $akcija->productID }}'>{{ $proizvodi[$akcija->productID]->naziv }}</a></td>
      		<td>
      			<form method="post" id="forma{{ $akcija->productID }}" enctype="multipart/form-data" action="/adminPanel/posebneAkcije">
      				@csrf @method("POST")
      				<input type="hidden" name="productID" value="{{ $akcija->productID }}">
      				<input type="file" data-akcija="update" class="slike" name="slika">
      			</form>
      		</td>
      		<td class="text-right">
      			<button type="button" data-toggle="modal" data-target="#exampleModal" data-akcija="delete" data-user="{{ $akcija->productID }}" class="btn btn-outline-danger btn-round"> </i><i class="far fa-trash-alt"></i></button>
      		</td>
      	</tr>
      @endforeach

	      <tr>
	        <td colspan="3">
	          <b>Kreiraj posebnu akciju</b>
	        </td>
	        <td class="text-right">
	          <button type="button" data-target="#collapseExample" aria-expanded="false" data-toggle="collapse" aria-controls="collapseExample" class="btn btn-outline-success btn-round"> <i class="fas fa-plus-circle"></i></i></button>
	        </td>
	      </tr>

	      <tr class="collapse" id="collapseExample">
	        <td colspan="4">
	        <div class="card card-body">
	          <form method="post" id="forma" enctype="multipart/form-data" action="/adminPanel/posebneAkcije">
	            @csrf
	            @method("PUT")
	            <input type="hidden" id="productID" name="productID" value="0">
	            <div class="form-group">
	            <label for="searchPolje">Odaberi proizvod za koji se kreira akcija</label>
	            <input type="text" name="searchPolje" id="searchPolje" class="podaci search form-control" placeholder="Naziv proizvoda" autocomplete="off">
	            <div class="collapse acPolje">
          		</div>
	              <div class="invalid-feedback">
	                Ovo polje ne smije biti prazno!
	              </div><hr>

	              <label for="slika">Izaberi sliku: (poželjna veličina slike je 1500x400 pixela)</label>
	              <input type="file" name="slika" class="podaci form-control-file" id="exampleFormControlFile1">
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
              Jeste li sigurni da želite <span class="akcija"></span> ovu akciju (id proizvoda: <span id="idKor"></span>) ?
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

  $(".slike").change(function(){
  	var modal = $('#exampleModal');
  	modal.modal('show');
  	modal.find('.akcija').text('uploadati novu sliku za');
  	$("#akcija").addClass("btn-outline-success");
  	$("#akcija").html("Upload");
  	var button = $(this).closest("td").next("td").find("button");
  	modal.find('#idKor').text(button.data('user'));
  });

  $(".search").keyup(function(){
    var tekst = $(this).prop("value");
    tekst = tekst.replace(/[^a-z0-9\s]/gi, '');
    if(tekst != '' && tekst != ' '){
      $('.acPolje').fadeIn(600, function(){
        saljiUpit(tekst, "/getProductByString/", "get");
      });
    }else{
      $('.acPolje').fadeOut(600);
    }
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

  function popuni(data, status, tekst){
    var niz = Object.values(data);
    var proizvodi = niz[1];

    if(!status){
      $('.acPolje').empty();
      $('.acPolje').append("<div class='proizvod' data-id='0'>Nema rezultata za vašu pretragu: "+tekst+"</div>");
      return false;
    }

    $('.acPolje').empty();
    var itemNaziv;
    var itemID;
    for(var i = 0; i < proizvodi.length; i++){
      itemNaziv = proizvodi[i]['naziv'];
      itemID = proizvodi[i]['id'];
      $('.acPolje').append("<div class='proizvod' data-identif='"+itemID+"'>"+itemNaziv+"</div>");
    }
  }

  function saljiUpit(vrijednost, urlPoziva, method){
    request = $.ajax({
      url: urlPoziva+vrijednost,
      type: method,
      data: {}
    });

    request.done(function (response, textStatus, jqXHR){
      data = JSON.parse(response);
      popuni(data, data.status, vrijednost);
    });
  }

	$("body").on("click", ".proizvod", function(){
		var naziv = $(this).text();
		var id = $(this).data("identif");
		$(".search").prop("value", naziv);
		$("#productID").prop("value", id);
		$('.acPolje').fadeOut(600);
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
      }else{
      	var id = modal.find('#idKor').text();
      	$("#forma"+id).submit();
      }

    });
  });

}); 
</script>
<style>

.proizvod{
  border-bottom: 1px solid #e0e0e0;
  padding: 5px;
  padding-left: 10px;
}

.link{
  color: inherit;
}

.link:hover{
  color: inherit;
  text-decoration: underline;
}

.proizvod:hover{
	cursor: pointer;
  background-color: #fafafa;
}

.acPolje{
	border: 1px solid #e0e0e0;
	border-top: none;
	border-radius: 0px 0px 4px 4px;
-webkit-box-shadow: 1px 4px 5px -1px rgba(0,0,0,0.48);
-moz-box-shadow: 1px 4px 5px -1px rgba(0,0,0,0.48);
box-shadow: 1px 4px 5px -1px rgba(0,0,0,0.48);
}

body{
  font-family: 'Barlow Condensed', sans-serif;
}

.center{
    width: 800px;
    margin-left: auto;
    margin-right: auto;
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