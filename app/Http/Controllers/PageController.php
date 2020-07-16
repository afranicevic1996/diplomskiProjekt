<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

class PageController extends Controller
{
	public function index(Request $request){
		$kategorije = DB::table("kategorija")->get();
		$topProizvodi = DB::table("visits")->orderBy("clicks", "desc")->take(8)->get();
		
		foreach($topProizvodi as $topProizvod){
			$productID = $topProizvod->productID;
			$query = DB::table("products")->where("id", $productID)->get();
			$productInfo[] = $query;
			$slike[$productID] = DB::table("slike")->where("productID", $productID)->first();
		}

		$count = 0;
		$count = DB::table("posebneakcije")->count();
		if(!$count){
			$akcije = 0;
		}else{
			$akcije = DB::table("posebneakcije")->get();
		}

		/*print_r($productInfo);
		echo "<br>";
		echo $productInfo[0][0]->naziv;*/
		return view('welcome', ['kategorije' => $kategorije, 'proizvodi' => $productInfo, 'slike' => $slike, 'akcije' => $akcije]);
	}
}

?>