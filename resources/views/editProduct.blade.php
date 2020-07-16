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
        <a href="/adminPanel/editProducts" class="list-group-item list-group-item-action active">Uredi proizvod</a>
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

      <span id="formDio"></span>
      <center><legend>Uredi postojeći proizvod</legend></center>
      <hr>
      <div class="form-row center">
	      <div class="form-group col-md-12">
	      	<label class="sr-only" for="inlineFormInputGroup">Username</label>
      		<div class="input-group mb-2">
        		<div class="input-group-prepend">
          		<div class="input-group-text"><i class="fas fa-search"></i></div>
        		</div>
        		@if(session()->has('tekst'))
        			<input type="text" class="form-control search" id="inlineFormInputGroup" value="{{ session()->get('tekst') }}" placeholder="Upišite naziv proizvoda">
        		@else
        			<input type="text" class="form-control search" id="inlineFormInputGroup" placeholder="Upišite naziv proizvoda">
        		@endif
	      	</div>
	    	</div>
	    </div>

      <table class="table table-hover shopping-cart-wrap">
	      <thead class="text-muted">
	      <tr>
	      	<th scope="col" width="30">ID</th>
	        <th scope="col" width="380">Proizvod</th>
	        <th scope="col" width="120">Cijena</th>
	        <th scope="col" width="440">Opis</th>
	        <th scope="col" width="160">Dostupnost</th>
	        <th scope="col" width="190">Kategorija</th>
	        <th scope="col" class="text-right">Akcije</th>
	      </tr>
	      </thead>
	      <tbody>
	      </tbody>
    	</table>

      <hr><br><br>

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
              Jeste li sigurni da želite <span class="akcija"></span> ovaj proizvod (id: <span id="idKor"></span>) ?
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
  	var request;
  	var data;


  	@if(session()->has('tekst'))
  		saljiUpit("{{ session()->get('tekst') }}", "/getProductByString/", "get");
  	@endif

  	@if(session()->has('status'))
  		setTimeout(function() {
		  $('.alert').fadeOut('slow');
		}, 5000);
  	@endif







  	function saljiUpit(vrijednost, urlPoziva, method){
		request = $.ajax({
	    url: urlPoziva+vrijednost,
	    type: method,
	    data: {}
		});

	    request.done(function (response, textStatus, jqXHR){
	        data = JSON.parse(response);
	        var niz = Object.values(data);
	        //console.log(niz[3]);
	        var proizvodi = niz[1];
	        var slike = niz[2];
	        var kategorije = niz[3];
	        //console.log(proizvodi);

	        if(!data.status){ //ako nije nadjen niti jedan proizvod
	        	$("tbody").empty();
	        	$("#formDio").empty();
	        	$("tbody").append("<tr><td colspan='7'><center>Nema proizvoda koji odgovaraju vašoj pretrazi!</center></td></tr>");
	        	return false;
	        }

	        $("#formDio").empty();
	        $("tbody").empty();
	        var naziv, cijena, opis, dostupnost, kate, htmlTekst, pomDost, pomKate, deleteForma, editForma;
	        var i = 0, j = 0;

	        //dio za listanje proizvoda
	        for(i = 0; i < proizvodi.length; i++){
	        	placeholderSlika = slike[i][0]['fileName'];
	        	id = proizvodi[i]['id'];
	        	naziv = proizvodi[i]['naziv'];
	        	cijena = proizvodi[i]['cijena'];
	        	opis = proizvodi[i]['opis'];

	        	//dio za dostupnost
	        	dostupnost = proizvodi[i]['dostupnost'];
	        	if(dostupnost){ //1
	        		pomDost = "<select name='dostupnost' form='formaUpdate"+id+"' id='dostupnost"+id+"' class='podaci browser-default custom-select'><option value='1' selected>Dostupno</option>"+
						              "<option value='0'>Nedostupno</option>"+
						            "</select>";
	        	}else{
	        		pomDost = "<select name='dostupnost' form='formaUpdate"+id+"' class='podaci browser-default custom-select'><option value='0' selected>Nedostupno</option>"+
						              "<option value='1'>Dostupno</option>"+
						            "</select>";
	        	}

	        	//dio za kategorije
	        	kate = proizvodi[i]['kategorija'];
	        	pomKate = "<select name='kategorija' form='formaUpdate"+id+"' id='kategorija"+id+"' class='podaci browser-default custom-select'>";
	        	for(j = 0; j < kategorije.length; j++){
	        		if(kategorije[j]['id'] == kate){
	        			pomKate += "<option value='"+kate+"' selected>"+kategorije[j]['naziv']+"</option>";
	        		}else{
	        			pomKate += "<option value='"+kategorije[j]['id']+"'>"+kategorije[j]['naziv']+"</option>";
	        		}
	        	}
	        	pomKate += "</select>";

				//dio za formu
				editForma = "<form id='formaUpdate"+id+"' action='/editProduct' method='post'><input name='_token' value='{{ csrf_token() }}' type='hidden'><input type='hidden' name='id' value='"+id+"'><input name='vrijednost' value='"+vrijednost+"' type='hidden'></form>";
	    			/*"<input name='_token' value='{{ csrf_token() }}' type='hidden'>"+
	    			"<input type='hidden' name='id' value='"+id+"'>"+
	    			"<input type='text' name='cijena' value='"+cijena+"' placeholder='Cijena'>"+
	    			"<input type='text' name='kategorija' value='"+cijena+"' placeholder='Cijena'>"+*/

	        	//dio za delete formu
	        	deleteForma = "<form id='formaDel"+id+"' style='display: inline;' action='/deleteProduct' method='post'>"+
	    			"<input name='_token' value='{{ csrf_token() }}' type='hidden'>"+
	    			"<input type='hidden' name='id' value='"+id+"'>"+
	    			"<input name='vrijednost' value='"+vrijednost+"' type='hidden'>"+
	    			"<button type='button' data-toggle='modal' data-target='#exampleModal' data-akcija='delete' data-user='"+id+"' class='delete btn btn-outline-danger btn-round'> </i><i class='far fa-trash-alt'></i></button>"+
	    			"</form>";

	        	htmlTekst = "<tr><td><b>"+id+"</b></td>"+
	        	  "<td><figure class='media'><div class='img-wrap'><img src='/"+placeholderSlika+"' class='img-thumbnail img-sm' style='margin-right: 5px'></div>"+
	              "<figcaption class='media-body'><h6 class='title text-truncate'><input type='text' form='formaUpdate"+id+"' name='naziv' value='"+naziv+"' placeholder='Naziv' class='form-control'></h6></figcaption></figure></td>"+
	              "<td><input type='text' form='formaUpdate"+id+"' name='cijena' value='"+cijena+"' placeholder='Cijena' class='float form-control'></td>"+
	              "<td><textarea name='opis' form='formaUpdate"+id+"' class='podaci form-control' rows='4'>"+opis+"</textarea></td>"+
	              "<td>"+pomDost+"</td>"+
	              "<td>"+pomKate+"</td>"+
	              "<td class='text-right'>"+
	              	"<button type='button' data-toggle='modal' data-target='#exampleModal' data-akcija='update' data-user='"+id+"' class='btn btn-outline-success btn-round'> <i class='far fa-save'></i></a></button> "+
	              	deleteForma+
	              "</td>"+
	              "</tr>";

	            $("#formDio").append(editForma);
	        	$("tbody").append(htmlTekst);
	        }
	        //proizvodi.forEach(readProizvod);
	    });
	}
























  	$(".search").keyup(function(){
  		var tekst = $(this).val();
  		var url = "/getProductByString/";
  		$("#formDio").empty();
  		$("tbody").empty();
  		if(tekst != '' && tekst != ' '){
  			saljiUpit(tekst, url, "get");
		}

  	});
	

	//modal
    $('#exampleModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var productID = button.data('user'); // Extract info from data-* attributes
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
      modal.find('#idKor').text(productID);

      $("#akcija").click(function(){
        if(akcija == "delete"){
          $("#formaDel"+productID).submit();
        }

        if(akcija == "update"){
          $("#formaUpdate"+productID).submit();
        }

      });
    });

    //regex za cijenu
	$(document).on("keypress", '.float', function(e) { 
      if ((e.which != 46 || $(this).val().indexOf('.') != -1) && (e.which < 48 || e.which > 57)) {
        e.preventDefault();
      }
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

.center{
    width: 500px;
    margin-left: auto;
    margin-right: auto;
}

    .navbar {
      margin-bottom: 50px;
      border-radius: 0;
    }
    
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
      margin-bottom: 0;
    }

  	img {
	  width: 120px;
	  height: 120px;
	}   

    .jumbotron {
      background: url("{{ URL::asset('shop.jpg') }}") no-repeat;
    }

footer{
  background-color: #292b2c;
}
</style>
</html>