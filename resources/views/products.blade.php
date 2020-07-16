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

  <!--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>

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
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }

    .jumbotron {
      background: url("{{ URL::asset('shop.jpg') }}") no-repeat;
    }
  </style>
</head>
<body>
<?php 
  $url = $proizvodi->appends($_GET)->url(1);
  //App::abort(404, "greskade");
  if(isset($_REQUEST['page'])){
    $page = $_REQUEST['page'];
    $count = $proizvodi->total();
    $totalStranica = ($count / 5);
    if(!ctype_digit((string)$totalStranica)){
      $totalStranica = floor($totalStranica)+1;
    }

    if($page > $totalStranica){
      header("Location: $url");
      exit();
    }
  }
?>
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
                @if($trenutnaKate == $kate->id)
                  <a href="/products?kategorija={{ $kate->id }}" style="height: 40px; padding: 10px 15px;" class="list-group-item list-group-item-action active">
                  <i class="fas fa-chevron-right"></i> {{ $kate->naziv }}</a>
                @else
                  <a href="/products?kategorija={{ $kate->id }}" style="height: 40px; padding: 10px 15px;" class="list-group-item list-group-item-action">
                  <i class="text-primary fas fa-chevron-right"></i> {{ $kate->naziv }}</a>         
                @endif        
              @endif
            @endforeach
          </div>
        </div>

        @foreach($kategorije as $kate)
          @if(!$kate->komponenta)
            @if($trenutnaKate == $kate->id)
              <a href="/products?kategorija={{ $kate->id }}" class="list-group-item list-group-item-action active">{{ $kate->naziv }}</a>
            @else
              <a href="/products?kategorija={{ $kate->id }}" class="list-group-item list-group-item-action">{{ $kate->naziv }}</a>
            @endif
          @endif
        @endforeach
      </div>
    </div>

    <div class="col-lg-8">
      <!--<center><legend>-->
        @if(!$trenutnaKate)
          <div class="naziv">Lista svih proizvoda</div>
        @else
          @foreach($kategorije as $kate)
            @if($trenutnaKate == $kate->id)
              <div class="naziv">{{ $kate->naziv }}</div>
            @endif
          @endforeach
        @endif
      <!--</legend></center>-->
      <div class="ponuda">
        <table class="table table-hover shopping-cart-wrap">
          <thead class="text-muted">
          <tr>
            <th scope="col">Proizvod</th>
            <th scope="col" width="120">Cijena</th>
            <th scope="col" width="100">Dostupnost</th>
            <th scope="col" width="360">Opis</th>
            <th scope="col" class="text-right"></th>
          </tr>
          </thead>
          <tbody>
            @if(!$count)
              <tr><td colspan="5"><center>Nema rezultata pretrage</center></td></tr>
            @endif

            @foreach($proizvodi as $proizvod)
            <?php $link = URL::asset($slike[$proizvod->id]->fileName); ?>
            <?php $opis = substr($proizvod->opis, 0, 300)."..."; ?>
            <tr>
              <td>
                <figure class="media">
                  <div class="img-wrap"><img src="{{ $link }}" class="img-thumbnail img-sm" style="margin-right: 5px"></div>
                  <figcaption class="media-body">
                    <h6 class="title text-truncate"><a href="/product/{{ $proizvod->id }}" class="inherit">{{ $proizvod->naziv }}</a></h6>
                  </figcaption>
                </figure> 
              </td>
              <td>
                {{ $proizvod->cijena }} Kn
              </td>
              <td>
              @if($proizvod->dostupnost)
                  <i class="fas fa-check text-success"></i>
                @else
                  <i class="fas fa-times text-danger"></i>
                @endif
              </td>
              <td> 
                {{ $opis }}
              </td>
              <td class="text-right">
                @if($proizvod->dostupnost)
                  <form style="display: inline;" action="/addToCart/{{ $proizvod->id }}" method="post">
                   @csrf
                   <input type="hidden" id="item{{ $proizvod->id }}" name="kolicina" value="1">
                   <input type="hidden" name="cijena" value="{{ $proizvod->cijena }}">
                   <button title="" id="buy{{ $proizvod->id }}" class="btn btn-outline-success" data-toggle="tooltip" data-original-title="Save to Wishlist"> <i class="fas fa-shopping-cart"></i></button>
                  </form>
                @else
                  <a title="" href="" class="btn btn-outline-success disabled" data-toggle="tooltip" data-original-title="Save to Wishlist"> <i class="fas fa-shopping-cart"></i></a>
                @endif
                <a href="/product/{{ $proizvod->id }}" class="btn btn-outline-secondary btn-round">Detalji <i class="fas fa-arrow-right"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <hr>
        <div>
          {{ $proizvodi->appends($_GET)->links() }}
        </div>
      </div>
      <br>
    </div>

    <div class="col-lg-2">
      <div class="list-group noRadis">
        <a href="" class="list-group-item list-group-item-dark inactiveLinkRed"><center>Filteri za pretragu</center></a>
      </div>
      <div class="list-group searchDiv">
        <form class="appendForm" method="get" action="">
          <br>
          Način sortiranja: 
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="sort" value="1" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
              Po cijeni (uzlazno)
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="sort" value="2" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
              Po cijeni (silazno)
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="sort" value="3" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
              Po imenu (uzlazno)
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="sort" value="4" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
              Po imenu (silazno)
            </label>
          </div>
          <hr>

          Cijena između: 
          <span name="slider" id="amount"></span>
          <div id="slider-range"></div>
          <input type="hidden" name="cijenaOd" id="cijenaOd">
          <input type="hidden" name="cijenaDo" id="cijenaDo">
          <hr>

          Ključna riječ za pretragu:
          <input type="text" id="rijec" class="form-control form-control-sm" placeholder="Ključna riječ" name="tekst"><hr>
          <button class="btn btn-outline-danger btn-round search">Pretraži</button>
          <a href="" class="clear btn btn-outline-secondary btn-round">Očisti filtere</a>
        </form><br>
      </div>
    </div>

  </div>
</div>
<button style="display: none;" class="cijenaBar">Pretraži</button>

</body>
<style>

.naziv{
  text-align: center;
  padding: 7px;
  border: 1px solid #e0e0e0;
  border-bottom: none;
  border-radius: 4px 4px 0px 0px;
  color: white;
  background-color: #0275d8;
  text-shadow: 1px 0px black;
}

.ponuda{
  border: 1px solid #e0e0e0;
  padding: 20px;
  border-radius: 0px 0px 4px 4px;
  background-color: white;
}

body{
  font-family: 'Barlow Condensed', sans-serif;
  background-color: #ededed;
}

.inherit{ color: inherit; } 
.inherit:hover{ 
  color: inherit;
  text-decoration: underline;
} 

.card-body{
  margin: 0px;
  padding: 0px;
}

.fa-chevron-right{
  font-size: 10px;
}

.appendForm .form-control{
  width: 75%;
  margin: 0 auto;
}

#slider-range{
  width: 75%;
    margin: 0 auto;
}

.ui-slider-range{
  background-color: #d9534f;
}

#amount{
  color: #d9534f;
}

.noRadis{
   border-bottom-right-radius: 0px;
  border-bottom-left-radius: 0px; 
}

.inactiveLinkBlue {
   pointer-events: none;
   cursor: default;
   background-color: #0275d8;
   color: white;
}

.searchDiv{
    height:auto; 
    margin:0 auto;
  text-align: center;
  border: 1px solid #d9534f;
  border-top: none;
  border-top-right-radius: 0px;
  border-top-left-radius: 0px;
  background-color: white;
}

.inactiveLinkRed{
   pointer-events: none;
   cursor: default;
   background-color: #d9534f;
   color: white;
}

.center{
    width: 1000px;
    margin-left: auto;
    margin-right: auto;
}

    img {
    width: 120px;
    height: 120px;
  }


</style>
<script>

$(document).ready(function(){

cijenaSlider(0, 0);
  var i = 0;
  @foreach($kategorije as $kate)
    @if($trenutnaKate == $kate->id && $kate->komponenta == 1)
      if(i == 0){
        $(".collapse").addClass("show");
        $(".strelica").toggleClass("fa-chevron-down fa-chevron-up");
        i++;
      }
    @endif
  @endforeach

  $(".search").click(function(){
    $(".added").each(function(){
      $(this).remove();
    });
  });

  $("input[name='sort']").click(function(){
      $("input[name='sort']").prop("checked", false);
      $(this).prop("checked", true);
  });

  $(".clear").click(function(e){
    e.preventDefault();
    $(".ui-slider-handle").css("left", "0%");
    $(".ui-slider-range").css("width", "0%");
    $("#amount").text("");
    $("#cijenaOd").val('').trigger('change');
    $("#cijenaDo").val('').trigger('change');
    $("input[name='sort']").prop("checked", false);
    $("input[name='proiz[]']").prop("checked", false);
    $("input[name='tekst']").val("");
    $(".added").each(function(){
      $(this).remove();
    });
  });

  /*$( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 10000,
      values: [ 0, 0 ],
      slide: function( event, ui ) {
        $( "#amount" ).text(ui.values[ 0 ] + " Kn - " + ui.values[ 1 ] + " Kn" );
        $("#cijenaOd").val(ui.values[ 0 ]);
        $("#cijenaDo").val(ui.values[ 1 ]);
      }
    });
    $( "#amount" ).text($( "#slider-range" ).slider( "values", 0 ) + " Kn - "
      + $( "#slider-range" ).slider( "values", 1 ) + " Kn");
  } );*/


//$('body').myfunction(0, 4000);


  (function($){
    $.QueryString = (function(paramsArray){
      let params = {};

      for (let i = 0; i < paramsArray.length; ++i){
        let param = paramsArray[i].split('=', 2);
              
        if(param.length !== 2)
            continue;
              
        params[param[0]] = decodeURIComponent(param[1].replace(/\+/g, " "));
      }
              
          return params;
    })(window.location.search.substr(1).split('&'))
  })(jQuery);

  var cijenaOd;
  var cijenaDo;
  var htmlInput;
  var provjera = 0;
  var keyProvjera = 0;
  $.each($.QueryString, function(key, value){
    if(key == "kategorija" || key == "page"){
      htmlInput = "<input type='hidden' name='"+key+"' value='"+value+"'>";
    }else{
      htmlInput = "<input type='hidden' class='added' name='"+key+"' value='"+value+"'>";
    }
    $('.appendForm').append(htmlInput);

    if(key == "sort"){
      $("input[name='sort']").each(function(){
        if($(this).prop("value") == value){
          $(this).prop("checked", true);
        }
      });
    }

    if(key == "tekst"){
      $("#rijec").prop("value", value);
    }

    if(key == "cijenaOd"){
      keyProvjera++;
      if(!isNaN(value)){
        cijenaOd = value;
        $("#cijenaOd").prop("value", cijenaOd);
        provjera++;
      }
    }

    if(key == "cijenaDo"){
      keyProvjera++;
      if(!isNaN(value)){
        cijenaDo = value;
        $("#cijenaDo").prop("value", cijenaDo);
        provjera++;
      }
    }

  });

  if(keyProvjera == 0){
    cijenaSlider(0, 0);
  }else if(provjera > 0){
    cijenaSlider(cijenaOd, cijenaDo);
  }


  $("#resetPolja").click(function(){
    $("#username").val('');
    $("#password").val('');
  });

  $(".klik").click(function(){
    $(".strelica").toggleClass("fa-chevron-down fa-chevron-up");
  });
});

   function cijenaSlider(valueLow, valueHigh){
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 10000,
      values: [ valueLow, valueHigh ],
      slide: function( event, ui ) {
        $( "#amount" ).text(ui.values[ 0 ] + " Kn - " + ui.values[ 1 ] + " Kn" );
        $("#cijenaOd").val(ui.values[ 0 ]);
        $("#cijenaDo").val(ui.values[ 1 ]);
      }
    });
    $( "#amount" ).text($( "#slider-range" ).slider( "values", 0 ) + " Kn - "
      + $( "#slider-range" ).slider( "values", 1 ) + " Kn");
      //return this;
   }
</script>
</html>