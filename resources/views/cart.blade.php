<!DOCTYPE html>
<html lang="en">
<head>
  <title>Product</title>
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
      <a class="btn btn-outline-success btn-round" href="/cart" role="button"><i class="fas fa-shopping-cart"></i> Košarica ({{ count(session()->get('kosarica')) }})</a>&nbsp;
      <a class="btn btn-outline-secondary btn-round" href="/editProfil" role="button">Uredi profil (@if(session()->has('username')){{ session()->get('username') }}@endif)</a>&nbsp;
      <a class="btn btn-outline-danger btn-round" href="/logout" role="button">Odjava</a>
    @endif
  </div>
</nav>

<div class="container">
 <div class="row">
  <div class="col-lg-12">

	<ul class="nav nav-tabs" id="myTab" role="tablist">
	  <li class="nav-item" role="presentation">
	    <a class="nav-link active home disabled" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Košarica</a>
	  </li>
	  <li class="nav-item" role="presentation">
	    <a class="nav-link contact disabled" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Provjera podataka i način plaćanja</a>
	  </li>
	  <li class="nav-item" role="presentation">
	    <a class="nav-link nacin disabled" id="nacin-tab" data-toggle="tab" href="#nacin" role="tab" aria-controls="nacin" aria-selected="false">Uvjeti korištenja</a>
	  </li>
	</ul>

	<div class="tab-content" id="myTabContent">
	  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
	  	<a id="proba" class="btn btn-outline-success btn-round btnNext hiddenTab">Blagajna <i class="fas fa-arrow-right"></i></a> <!-- skriveni -->

	  	<legend>Uredite košaricu</legend>
	    @if(!count(session()->get('kosarica')) || empty($info))
	    <span>Vaša košarica je prazna!</span>
	    @else
	    <table class="table table-hover shopping-cart-wrap">
	      <thead class="text-muted">
	      <tr>
	        <th scope="col">Proizvod</th>
	        <th scope="col" width="120">Količina</th>
	        <th scope="col" width="150">Cijena/kom</th>
	        <th scope="col" width="160" class="text-right"></th>
	      </tr>
	      </thead>
	      <tbody>
	      <?php 
	        $ukupnaCijena = 0.00; $i = 0;
	        $proizvodi = session()->get('kosarica');
	      ?>
	      @foreach($info as $item)
	        <?php $ukupnaCijena += floatval($item[0]->cijena * $proizvodi[$i]['kolicina']);
	        	  $slika = URL::asset($slike[$i]->fileName);
	       	?>
	        <tr>
	          <td>
	            <figure class="media">
	              <div class="img-wrap"><img src="{{ $slika }}" class="img-thumbnail img-sm" style="margin-right: 5px"></div>
	              <figcaption class="media-body">
	                <h6 class="title text-truncate">{{ $item[0]->naziv }}</h6>
	              </figcaption>
	            </figure> 
	          </td>
	          <td>
	            <form style="display: inline;" action="/updateKolicina/{{ $item[0]->id }}" method="post" class="forma{{ $item[0]->id }}">
	              @csrf
	              <input name="kolicina" type="number" min="1" oninput="validity.valid||(value='');" value="{{ $proizvodi[$i++]['kolicina'] }}" placeholder="Količina" class="form-control kolicina" required>
	            </form>
	          </td>
	          <td>
	            <div class="price-wrap"> 
	              <var class="price">{{ $item[0]->cijena }} Kn</var> <br>
	              <small class="text-muted"></small> 
	            </div>
	          </td>
	          <td class="text-right">
	            <a href="/product/{{ $item[0]->id }}" class="btn btn-outline-secondary btn-round">Detalji <i class="fas fa-arrow-right"></i></a>
	            <form style="display: inline;" action="/removeFromCart/{{ $item[0]->id }}" method="post">
	              @csrf
	              <button title="" class="btn btn-outline-danger btn-round" data-toggle="tooltip" data-original-title="Save to Wishlist"> <i class="far fa-trash-alt"></i></button>
	            </form>
	          </td>
	        </tr>
	      @endforeach
	      <tr>
	        <td>Poštarina:</td>
	        <td></td>
	        <td></td>
	        @if($ukupnaCijena >= 1000)
	          <td class="text-right">0.00 Kn</td>
	        @else
	          <td class="text-right">30.00 Kn</td>
	        @endif
	      </tr>
	      <tr>
	        <td>Ukupno:</td>
	        <td></td>
	        <td></td>
	        <td class="text-right">{{ $ukupnaCijena }} Kn</td>
	      </tr>
	      <tr>
	        <tr scope="row"></tr>
	        <td></td>
	        <td></td>
	        <td class="text-right" colspan="3">
	          <a href="" class="btn btn-outline-secondary btn-round"><i class="fas fa-arrow-left"></i> Nastavite kupovati</a>
	          <a href="#" id="sssss" class="btn btn-outline-success btn-round klikNext">Dalje <i class="fas fa-arrow-right"></i></a>
	        </td>
	      </tr>
	    </tbody>
	  	</table>
	  	@endif
	    <!--<a class="btn btn-outline-secondary btn-round btnNext" >Next</a>-->
	  </div>

	  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
	  	<a class="btn btn-outline-success btn-round btnPrevious hiddenTab">Blagajna <i class="fas fa-arrow-right"></i></a> <!-- skriveni -->
	  	<a class="btn btn-outline-success btn-round btnNext hiddenTab">Blagajna <i class="fas fa-arrow-right"></i></a> <!-- skriveni -->
	  	<legend>Molimo vas upišite potrebne osobne podatke!</legend>
	  	<span>Određeni podaci se automatski popunjavaju direktno sa vašeg profila.</span>
	  	<hr>
	  	<form id="forma" method="POST" action="/blagajna">
	  	@csrf
		  <div class="form-row">
		    <div class="form-group col-md-6">
		      <label for="ime">Ime</label>
		      <input id="ime" name="ime" type="text" value="{{ $userInfo->ime }}" placeholder="Ime" class="form-control" required>
		    </div>
		    <div class="form-group col-md-6">
		      <label for="prezime">Prezime</label>
		      <input id="prezime" name="prezime" type="text" value="{{ $userInfo->prezime }}" placeholder="Prezime" class="form-control" required>
		    </div>
		  </div>
		  <div class="form-row">
		    <div class="form-group col-md-8">
		    	<label for="email">Email</label>
		    	<input id="email" name="email" type="email" value="{{ $userInfo->email }}" placeholder="primjer@primjer.com" class="form-control" required>
		  	</div>
		    <div class="form-group col-md-4">
		    	<label for="nacinpl">Način plaćanja</label>
		    	<select class="form-control" id="nacinpl" name="nacinpl" required>
			      <option value="pouzece" selected>Pouzećem</option>
			    </select>
		  	</div>
		  </div>
		  <div class="form-row">
		    <div class="form-group col-md-5">
		      <label for="telefon">Telefon</label>
		      <input id="telefon" name="telefon" type="number" min="0" oninput="validity.valid||(value='');" value="{{ $userInfo->telefon }}" placeholder="Telefon" class="form-control">
		    </div>
		    <div class="form-group col-md-5">
		      <label for="adresa">Adresa</label>
		      <input id="adresa" name="adresa" type="text" value="{{ $userInfo->adresa }}" placeholder="Adresa" class="form-control">
		    </div>
		    <div class="form-group col-md-2">
		      <label for="pbroj">Poštanski broj</label>
		      <input id="pbroj" name="pbroj" type="number" min="0" oninput="validity.valid||(value='');" value="{{ $userInfo->pbroj }}" placeholder="Poštanski broj" class="form-control">
		    </div>
		  </div>
		</form>
		<hr>
		<div class="d-flex flex-row-reverse">
			<a href="#" class="btn btn-outline-success btn-round klikNext checkPodaci">Dalje <i class="fas fa-arrow-right"></i></a>&nbsp;
			<a href="#" class="btn btn-outline-secondary btn-round klikPrevious"><i class="fas fa-arrow-left"></i> Nazad</a>
		</div>
	  </div>

	  <div class="tab-pane fade" id="nacin" role="tabpanel" aria-labelledby="nacin-tab">
	  	<a class="btn btn-outline-success btn-round btnPrevious hiddenTab">Blagajna <i class="fas fa-arrow-right"></i></a> <!-- skriveni -->
	  	<span>Prije finaliziranja prodaje molimo vas da pročitate naše <a href="/uvjetiKoristenja">opće uvjete korištenja.</a></span><br><br>
	  	<div class="form-check">
		  <input type="checkbox" class="form-check-input" id="check" name="checked">
		  <label class="form-check-label" for="exampleCheck1">Prihvaćam opće uvjete korištenja</label>
		</div>
	  	<div class="d-flex flex-row">
	  		<a href="#" class="btn btn-outline-secondary btn-round klikPrevious"><i class="fas fa-arrow-left"></i> Nazad</a>&nbsp;
	  		<a href="#" class="btn btn-outline-success btn-round blagajna disabled">Blagajna <i class="fas fa-arrow-right"></i></a>
	  	</div>
	  </div>



	</div>

  </div>
 </div>
</div>


</body>
<script>

  $(document).ready(function(){
    $(".kolicina").keypress(function (e){
      if (e.which == 13){
        var form = $(this).parents('form:first');
        form.submit();
      }
      //var buttonID = $(this).attr('id');
      //buttonID = buttonID.replace(/[^0-9]/g,'');
      //var kolicina = $(".item"+buttonID).val();

      //$("#item"+buttonID).val(kolicina);
    });
    
    $('#forma :input').each(function(){
    	if($(this).val() == ''){
	    	$(this).addClass("redBorder");
	    	$(".checkPodaci").addClass("disabled");
	    }
    });

    $('#forma :input').keyup(function(){
	    if($(this).val() == ''){
	    	$(this).addClass("redBorder");
	    }else{
	    	$(this).removeClass("redBorder");
	    }

	    var i = 0;
	    $('#forma :input').each(function(){
	    	if($(this).val() == ''){
		    	i++;
		    }
	    });

	    if(i == 0){
	    	$(".checkPodaci").removeClass("disabled");
	    }else{
	    	$(".checkPodaci").addClass("disabled");
	    }
	});

    $('.klikNext').click(function(){
    	var button = $(this).closest('.tab-pane').find('.btnNext');
    	button.click();
	});

	$('.klikPrevious').click(function(){
		var button = $(this).closest('.tab-pane').find('.btnPrevious');
    	button.click();
	});

   	$('.btnNext').click(function(){
		var klasa = $(this).parent().attr("id");
		$("."+klasa).removeClass("active");
		$("."+klasa).parent().next().children().addClass("active");

	  	$(this).parent().removeClass("show active");
	  	$(this).parent().next().addClass("show active");
	});

	$('.btnPrevious').click(function(){
		var klasa = $(this).parent().attr("id");
		$("."+klasa).removeClass("active");
		$("."+klasa).parent().prev().children().addClass("active");

	  	$(this).parent().removeClass("show active");
	  	$(this).parent().prev().addClass("show active");
	});

	$('#check').click(function(){
		var check = $('#check').is(":checked");
		if(check){
			$(".blagajna").removeClass("disabled");
		}else{
			$(".blagajna").addClass("disabled");
		}
	});

	$('.blagajna').click(function(){
		$("#forma").submit();
	});
  });

</script>
<style>

body{
  font-family: 'Barlow Condensed', sans-serif;
}
	a.hiddenTab {visibility:hidden; display:none;}

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
    position: relative;
    bottom: 0;
    width: 100%;
    background-color: #292b2c;
  }

  	img {
	  width: 120px;
	  height: 120px;
	}

	.redBorder{
		border: 1px solid red;
	}
</style>
</html>