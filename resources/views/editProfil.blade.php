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
	    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Uredi profil</a>
	  </li>
	  <li class="nav-item" role="presentation">
	    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Wishlist</a>
	  </li>
	  <li class="nav-item" role="presentation">
	    <a class="nav-link" id="kupovina-tab" data-toggle="tab" href="#kupovina" role="tab" aria-controls="kupovina" aria-selected="false">Povijest kupovina</a>
	  </li>
	</ul>
	<div class="tab-content" id="myTabContent">
	  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
	    <p>Vaši podaci se automatski unose prilikom narudžbe.</p>
	  	<form id="forma" method="POST" action="/editProfil">
	  	@csrf
		  <div class="form-row">
		    <div class="form-group col-md-6">
		      <label for="ime">Ime</label>
		      <input id="ime" name="ime" type="text" value="{{ $info['ime'] }}" placeholder="Ime" class="form-control" required>
		    </div>
		    <div class="form-group col-md-6">
		      <label for="prezime">Prezime</label>
		      <input id="prezime" name="prezime" type="text" value="{{ $info['prezime'] }}" placeholder="Prezime" class="form-control" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="email">Email</label>
		    <input id="email" name="email" type="email" value="{{ $info['email'] }}" placeholder="primjer@primjer.com" class="form-control" required>
		  </div>
		  <div class="form-group">
		    <label for="password">Password</label>
		    <input type="password" id="password" name="password" value="{{ $info['password'] }}" placeholder="Password" class="form-control" required>
		  </div>
		  <div class="form-row">
		    <div class="form-group col-md-5">
		      <label for="telefon">Telefon</label>
		      <input id="telefon" name="telefon" type="number" min="0" oninput="validity.valid||(value='');" value="{{ $info['telefon'] }}" placeholder="Telefon" class="form-control">
		    </div>
		    <div class="form-group col-md-5">
		      <label for="adresa">Adresa</label>
		      <input id="adresa" name="adresa" type="text" value="{{ $info['adresa'] }}" placeholder="Adresa" class="form-control">
		    </div>
		    <div class="form-group col-md-2">
		      <label for="pbroj">Poštanski broj</label>
		      <input id="pbroj" name="pbroj" type="number" min="0" oninput="validity.valid||(value='');" value="{{ $info['pbroj'] }}" placeholder="Poštanski broj" class="form-control">
		    </div>
		  </div>
		  <button type="submit" id="save" name="save" class="btn btn-outline-primary">Spremi</button>
		</form>  
	  </div>

	  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
		<h3>Vaša lista željenih proizvoda</h3>
	      @if($info['wishlist'] == 0)
	      	<p>Trenutno nemate niti jedan proizvod na listi.</p>
	      @else
			<table class="table table-hover shopping-cart-wrap">
			<thead class="text-muted">
			<tr>
			  <th scope="col">Proizvod</th>
			  <th scope="col" width="50">Dostupnost</th>
			  <th scope="col" width="100">Količina</th>
			  <th scope="col" width="150">Cijena/kom</th>
			  <th scope="col" width="230" class="text-right"></th>
			</tr>
			</thead>
			<tbody>
			<?php $i = 0; ?>
			@foreach($info['wishlist'] as $item)
			<?php $slika = URL::asset($info["slike"][$i++]->fileName); ?>
			<tr>
			  <td>
			<figure class="media">
			  <div class="img-wrap"><img src='{{ $slika }}' class="img-thumbnail img-sm" style="margin-right: 5px"></div>
			  <figcaption class="media-body">
			    <h6 class="title text-truncate">{{ $item->naziv }}</h6>
			  </figcaption>
			</figure> 
			  </td>
			  <td>
			  	@if($item->dostupnost)
			    	<i class="fas fa-check text-success"></i>
			    @else
			    	<i class="fas fa-times text-danger"></i>
			    @endif
			  </td>
			  <td>
			  	@if($item->dostupnost)
			  		<input id="telefon" name="telefon" type="number" min="1" oninput="validity.valid||(value='');" value="1" placeholder="Količina" class="form-control item{{ $item->id }}">
			  	@else
			  		<input id="telefon" name="telefon" type="number" min="0" oninput="validity.valid||(value='');" value="0" placeholder="Količina" class="form-control item{{ $item->id }}" disabled>
			  	@endif
			  </td>
			  <td> 
			    <div class="price-wrap"> 
			      <var class="price">{{ $item->cijena }} Kn</var> <br>
			      <small class="text-muted">(+30kn poštarina)</small> 
			    </div>
			  </td>
			  <td class="text-right">
			  	@if($item->dostupnost)
			  		<form style="display: inline;" action="/addToCart/{{ $item->id }}" method="post">
			  		 @csrf
			  		 <input type="hidden" id="item{{ $item->id }}" name="kolicina" value="1">
			  		 <input type="hidden" name="cijena" value="{{ $item->cijena }}">
			  		 <button title="" id="buy{{ $item->id }}" class="btn btn-outline-success" data-toggle="tooltip" data-original-title="Save to Wishlist"> <i class="fas fa-shopping-cart"></i></button>
			    	</form>
			    @else
			    	<a title="" href="" class="btn btn-outline-success disabled" data-toggle="tooltip" data-original-title="Save to Wishlist"> <i class="fas fa-shopping-cart"></i></a>
			    @endif
			  <a href="/product/{{ $item->id }}" class="btn btn-outline-secondary btn-round">Detalji <i class="fas fa-arrow-right"></i></a>
			  <form style="display: inline;" action="/deleteWish/{{ $item->id }}" method="post">
                @csrf
                <button title="" class="btn btn-outline-danger btn-round" data-toggle="tooltip" data-original-title="Save to Wishlist"> <i class="far fa-trash-alt"></i></button>
              </form>
			  </td>
			</tr>
			@endforeach
			</tbody>
			</table>
		  @endif
	  </div>










	  <div class="tab-pane fade" id="kupovina" role="tabpanel" aria-labelledby="kupovina-tab">
		<h3>Vaša lista prijašnjih kupovina</h3>
	      @if($info['kupovine'] == 0)
	      	<p>Niste kupili niti jedan proizvod.</p>
	      @else
			<table class="table table-hover shopping-cart-wrap">
			<thead class="text-muted">
			<tr>
			  <th scope="col">Proizvod</th>
			  <th scope="col" width="100">Količina</th>
			  <th scope="col" width="150">Cijena/kom</th>
			  <th scope="col" width="260" class="text-right"></th>
			</tr>
			</thead>
			<tbody>
			<?php $i = 0; ?>
			@foreach($info['kupovine'] as $item)
			<?php $slika = URL::asset($info["slikeKupovine"][$i]->fileName); ?>
			<tr>
			  <td>
			<figure class="media">
			  <div class="img-wrap"><img src='{{ $slika }}' class="img-thumbnail img-sm" style="margin-right: 5px"></div>
			  <figcaption class="media-body">
			    <h6 class="title text-truncate">{{ $item->naziv }}</h6>
			  </figcaption>
			</figure> 
			  </td>
			  <td>
			  	{{ $kolicina[$i] }}
			  </td>
			  <td> 
			    <div class="price-wrap"> 
			      <var class="price">{{ $item->cijena }} Kn</var> <br>
			    </div>
			  </td>
			  <td class="text-right">
			  	@if($komentar[$i] == 0)
			  		<button data-target="#collapseExample{{ $item->id }}" aria-expanded="false" data-toggle="collapse" aria-controls="collapseExample{{ $item->id }}" class="btn btn-outline-success btn-round">Ocijeni <i class="far fa-star"></i></button>
			  	@else
			  		<button data-target="#collapseExample{{ $item->id }}" aria-expanded="false" data-toggle="collapse" aria-controls="collapseExample{{ $item->id }}" class="btn btn-outline-success btn-round disabled" disabled>Ocijeni <i class="far fa-star"></i></button>
			  	@endif
				<a href="/product/{{ $item->id }}" class="btn btn-outline-secondary btn-round">Detalji <i class="fas fa-arrow-right"></i></a>
			  </td>
			</tr>

			@if($komentar[$i++] == 0)
			<tr class="collapse" id="collapseExample{{ $item->id }}">
			  <td colspan="4">
				<div class="card card-body">
				  <h6>Napišite komentar za ovaj proizvod: </h6>
				  <form method="post" action="/dodajKomentar/{{ $item->id }}">
				  	@csrf
					  <div class="form-group">
					    <textarea class="form-control" id="exampleFormControlTextarea1" name="komentar" rows="3" placeholder="Komentar"></textarea>
					  </div>
					  <div class="form-group">
					    <label for="exampleFormControlSelect1">Ocjena</label>
					    <select class="form-control" name="ocjena" id="exampleFormControlSelect1">
					      <option value="1">1</option>
					      <option value="2">2</option>
					      <option value="3">3</option>
					      <option value="4">4</option>
					      <option value="5">5</option>
					    </select>
					  </div>
					  <button class="btn btn-outline-primary btn-round">Pošalji</button>
				  </form>
				</div>
			  </td>
			</tr>
			@endif
			@endforeach
			</tbody>
			</table>
		  @endif
	  </div>
	</div>
  </div>
 </div>
 </div>

</body>
<script>

  $(document).ready(function(){
    $("button").click(function(){
    	var buttonID = $(this).attr('id');
    	buttonID = buttonID.replace(/[^0-9]/g,'');
    	var kolicina = $(".item"+buttonID).val();

    	$("#item"+buttonID).val(kolicina);
    });
  });

</script>
<style>
body{
  font-family: 'Barlow Condensed', sans-serif;
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
	  position: absolute;
	  bottom: 0;
	  width: 100%;
	  background-color: #292b2c;
	}

	img {
	  width: 120px;
	  height: 120px;
	}

</style>
</html>