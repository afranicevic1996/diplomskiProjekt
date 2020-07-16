<!DOCTYPE html>
<html lang="en">
<head>
  <title>eTrgovina</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script src="https://kit.fontawesome.com/f739741657.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

  <!--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
      <li class="nav-item active">
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
      @if(session()->get('role') == "admin")
        <a class="btn btn-outline-secondary btn-round" href="/adminPanel" role="button">Admin panel</a>&nbsp;
      @else
        <a class="btn btn-outline-success btn-round" href="/cart" role="button"><i class="fas fa-shopping-cart"></i> Košarica ({{ count(session()->get('kosarica')) }})</a>&nbsp;
        <a class="btn btn-outline-secondary btn-round" href="/editProfil" role="button">Uredi profil (@if(session()->has('username')){{ session()->get('username') }}@endif)</a>&nbsp;
      @endif
      <a class="btn btn-outline-danger btn-round" href="/logout" role="button">Odjava</a>
    @endif
  </div>
</nav>

<div class="container-fluid">    
  <div class="row">

    <div class="col-lg-2">
      <div class="list-group">
        <a href="" class="list-group-item list-group-item-dark inactiveLinkBlue"><center>Izaberite kategoriju proizvoda</center></a>
        <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="klik list-group-item list-group-item-action d-flex justify-content-between align-items-center">
          Komponente <i class="strelica text-primary fas fa-chevron-down"></i>
        </a>
        <div class="collapse" id="collapseExample">
          <div class="card card-body komp">
            @foreach($kategorije as $kate)
              @if($kate->komponenta)
                <a href="/products?kategorija={{ $kate->id }}" style="height: 40px; padding: 10px 15px;" class="list-group-item list-group-item-action">
                <i class="text-primary fas fa-chevron-right"></i> {{ $kate->naziv }}</a>                
              @endif
            @endforeach
          </div>
        </div>

        @foreach($kategorije as $kate)
          @if(!$kate->komponenta)
            <a href="/products?kategorija={{ $kate->id }}" class="list-group-item list-group-item-action">{{ $kate->naziv }}</a>
          @endif
        @endforeach
      </div>
    </div>

    <div class="col-lg-10">
      <div class="center">
        <div class="searchBar">
          <div class="form-row no-padding">
            <div class="form-group no-padding col-md-12">
              <label class="sr-only" for="inlineFormInputGroup">Username</label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fas fa-search"></i></div>
                </div>
                  <input type="text" class="form-control search" id="inlineFormInputGroup" placeholder="Pretražite eTrgovinu" autocomplete="off">
              </div>
            </div>
          </div>

          <div class="collapse acPolje">
          </div>
        </div>

        @if(is_object($akcije))
          <div class="naziv">Posebne akcije</div>
          <div class="ponuda">
            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
              <div class="carousel-inner">
                <?php $i = 0; ?>
                @foreach($akcije as $akcija)
                  <?php $link = URL::asset($akcija->fileName); ?>
                  @if($i == 0)
                    <div class="carousel-item active">
                      <a href="/product/{{ $akcija->productID }}"><img src='{{ $link }}' class="d-block w-100" alt="..."></a>
                    </div>  
                  @else                
                    <div class="carousel-item">
                      <a href="/product/{{ $akcija->productID }}"><img src='{{ $link }}' class="d-block w-100" alt="..."></a>
                    </div>
                  @endif
                  <?php $i++; ?>
                @endforeach         
              </div>
              <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
          </div>
        @endif
        

        <div class="naziv green">Najpopularniji proizvodi</div>
        <div class="ponuda">


          <div class="card-deck">
            <?php $i = 1; ?>
            @foreach($proizvodi as $proizvod)
            <?php $link = URL::asset($slike[$proizvod[0]->id]->fileName); ?>
            <?php $opis = substr($proizvod[0]->opis, 0, 300)."..."; ?>
              <div class="card">
                <img class="card-img-top" src="{{ $link }}" alt="Card image cap"><hr>
                <div class="card-body">
                  <h5 class="card-title"><a class="link" href="/product/{{ $proizvod[0]->id }}">{{ $proizvod[0]->naziv }}</a></h5>
                  <p class="card-text">{{ $opis }}</p>
                </div>
                <div class="card-footer text-right">
                  <span style="float:left;">{{ $proizvod[0]->cijena }}Kn</span>
                  <small class="text-muted">
                    @if($proizvod[0]->dostupnost)
                      <form style="display: inline;" action="/addToCart/{{ $proizvod[0]->id }}" method="post">
                       @csrf
                       <input type="hidden" id="item{{ $proizvod[0]->id }}" name="kolicina" value="1">
                       <input type="hidden" name="cijena" value="{{ $proizvod[0]->cijena }}">
                       <button title="" id="buy{{ $proizvod[0]->id }}" class="btn btn-outline-success" data-toggle="tooltip" data-original-title="Save to Wishlist"> <i class="fas fa-shopping-cart"></i></button>
                      </form>
                    @else
                      <a title="" href="" class="btn btn-outline-success disabled" data-toggle="tooltip" data-original-title="Save to Wishlist"> <i class="fas fa-shopping-cart"></i></a>
                    @endif
                    <a href="/product/{{ $proizvod[0]->id }}" class="btn btn-outline-secondary btn-round">Detalji <i class="fas fa-arrow-right"></i></a>
                  </small>
                </div>
              </div>
              @if($i % 4 == 0)
                </div><br><div class="card-deck">
              @endif
              <?php $i++; ?>
            @endforeach
          </div>


        </div>



      </div>
    </div>

  </div>
</div>



</body>
<style>

footer{
  position: absolute;
  width: 100%;
  background-color: #292b2c;
}

body{
  font-family: 'Barlow Condensed', sans-serif;
  background-color: #ededed;
}

span{
  margin-top: 6px;
}

.card:hover{
-webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.48);
-moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.48);
box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.48);
}

.card-body{
  margin-top: -25px;
}

.komp{
  margin: 0px;
  padding: 0px;
}

hr{
  border-bottom: 1px solid #5cb85c;
}

.card-img-top{
  max-height: 250px;
}

#carouselExampleFade{
  z-index: 1900 !important;
  width: 90%;
  margin-left: auto;
  margin-right: auto;

}

.form-group.no-padding{
 margin: 0 !important;
}

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
}

.proizvod:hover{
  background-color: #fafafa;
}

.searchBar .acPolje{
  position: absolute;
  border-radius: 0px 0px 4px 4px;
  border: 1px solid #e0e0e0;
  border-top: none;
  background-color: white;
  width: 44.2%;
  margin-top: -8px;
  z-index: 2000;
-webkit-box-shadow: 1px 4px 5px -1px rgba(0,0,0,0.48);
-moz-box-shadow: 1px 4px 5px -1px rgba(0,0,0,0.48);
box-shadow: 1px 4px 5px -1px rgba(0,0,0,0.48);
}

.searchBar{
  width: 50%;
  margin-left: auto;
  margin-right: auto;
  z-index: 2000;
}

.naziv{
  z-index: 1000;
  text-align: center;
  padding: 7px;
  border: 1px solid #e0e0e0;
  border-bottom: none;
  border-radius: 4px 4px 0px 0px;
  color: white;
  background-color: #d9534f;
  text-shadow: 1px 0px black;
}

.green{
  background-color: #5cb85c;
}

.ponuda{
  margin-bottom: 30px;
  z-index: 1000;
  border: 1px solid #e0e0e0;
  padding: 20px;
  border-radius: 0px 0px 4px 4px;
  background-color: white;
}

.navbar {
  margin-bottom: 50px;
  border-radius: 0;
}

.jumbotron {
  border-radius: 0;
  background: url("{{ URL::asset('shop.jpg') }}") no-repeat;
  margin-bottom: 0;
}

.fa-chevron-right{
  font-size: 10px;
}

.inactiveLinkBlue {
   pointer-events: none;
   cursor: default;
   background-color: #0275d8;
   color: white;
}

.inactiveLinkRed{
   pointer-events: none;
   cursor: default;
   background-color: #d9534f;
   color: white;
}

.center{
    width: 90%;
    margin-left: auto;
    margin-right: auto;
}

.carousel-inner{
  z-index: 1500 !important;
  width:80%;
  margin-left: auto;
  margin-right: auto;
  max-height: 400px !important;
}

.carousel-control-next-icon,
.carousel-control-prev-icon {
  /*z-index: 1950 !important;*/
  filter: invert(1);
  z-index: 3000;
}




</style>

<script>
$(document).ready(function(){
  $(".klik").click(function(){
    $(".strelica").toggleClass("fa-chevron-down fa-chevron-up");
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


  function popuni(data, status, tekst){
    var niz = Object.values(data);
    var proizvodi = niz[1];

    if(!status){
      $('.acPolje').empty();
      $('.acPolje').append("<div class='proizvod'>Nema rezultata za vašu pretragu: "+tekst+"</div>");
      return false;
    }

    $('.acPolje').empty();
    var itemNaziv;
    var itemID;
    for(var i = 0; i < proizvodi.length; i++){
      itemNaziv = proizvodi[i]['naziv'];
      itemID = proizvodi[i]['id'];
      $('.acPolje').append("<a href='/product/"+itemID+"' class='link'><div class='proizvod'>"+itemNaziv+"</div></a>");
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
});
</script>
</html>
