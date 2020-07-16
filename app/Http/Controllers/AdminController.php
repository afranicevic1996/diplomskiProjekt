<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

class AdminController extends Controller
{
	public function adminPanel(Request $request){
    	if(!$request->session()->has('username')){ //ako korisnik nije logiran onemoguci pristup
    		return redirect('/');
    	}

    	if($request->session()->get('role') != 'admin'){ //ako korisnik nije admin onemoguci pristup
    		return redirect('/');
    	}

    	$role = "user";
    	$users = DB::select('select * from users where role = ?', [$role]);
    	
    	return view('adminPanel', ['users' => $users]);
	}

	public function deleteUser(Request $request){
    	if(!$request->session()->has('username')){ //ako korisnik nije logiran onemoguci pristup
    		return redirect('/');
    	}

    	if($request->session()->get('role') != 'admin'){ //ako korisnik nije admin onemoguci pristup
    		return redirect('/');
    	}

		$userID = $request->id;
		if(!is_numeric($userID)){
			return redirect('/');
		}

		$query = DB::table('users')->where('id', '=', $userID)->delete();
		if($query){//user izbrisan
			$request->session()->flash('status', 'Korisnik uspješno izbrisan!');
			$request->session()->flash('error', 0);
			return redirect('/adminPanel');
		}

		//user nije izbrisan ili je doslo do greske
		$request->session()->flash('status', 'Došlo je do greške. Korisnik nije izbrisan!');
		$request->session()->flash('error', 1);
		return redirect('/adminPanel');
	}

	public function updateUser(Request $request){
    	if(!$request->session()->has('username')){ //ako korisnik nije logiran onemoguci pristup
    		return redirect('/');
    	}

    	if($request->session()->get('role') != 'admin'){ //ako korisnik nije admin onemoguci pristup
    		return redirect('/');
    	}

		$userID = $request->id;
		if(!is_numeric($userID)){
			return redirect('/');
		}

        $query = DB::table('users')->where('id', $userID)
                ->update(['ime' => "$request->ime", 'prezime' => "$request->prezime", 'username' => "$request->username", 'email' => "$request->email", /*'password' => $request->password,*/
                          'telefon' => "$request->telefon", 'adresa' => "$request->adresa", 'pbroj' => "$request->pbroj"]);

		if($query){//user editiran
			$request->session()->flash('status', 'Korisnik uspješno editiran!');
			$request->session()->flash('error', 0);
			return redirect('/adminPanel');
		}

		//user nije editiran ili je doslo do greske
		$request->session()->flash('status', 'Došlo je do greške. Korisnik nije editiran!');
		$request->session()->flash('error', 1);
		return redirect('/adminPanel');
	}

	public function addAdminUser(Request $request){
    	if(!$request->session()->has('username')){ //ako korisnik nije logiran onemoguci pristup
    		return redirect('/');
    	}

    	if($request->session()->get('role') != 'admin'){ //ako korisnik nije admin onemoguci pristup
    		return redirect('/');
    	}

		if($request->isMethod('get')){
			return view('addAdminUser');
		}

		$username = $request->username;
		$password = $request->password;

		$count = DB::table('users')->where('username', $username)->count();
		if($count){//vec postoji user sa takvim imenom
			$request->session()->flash('status', 'Došlo je do greške. Korisnik sa takvim imenom već postoji!');
			$request->session()->flash('error', 1);
			return redirect('/adminPanel/addAdminUser');
		}

        $query = DB::table('users')->insert(
            ['ime' => "", 'prezime' => "", 'email' => "", 'password' => "$password", 'username' => "$username", 'telefon' => "", 'adresa' => "", 'pbroj' => "", 'role' => 'admin']
        );

        if(!$query){//user nije dodan
			$request->session()->flash('status', 'Došlo je do greške. Korisnik nije dodan!');
			$request->session()->flash('error', 1);
			return redirect('/adminPanel/addAdminUser');
        }

		$request->session()->flash('status', 'Korisnik uspješno dodan!');
		$request->session()->flash('error', 0);
		return redirect('/adminPanel/addAdminUser');
	}

	public function addProduct(Request $request){
    	if(!$request->session()->has('username')){ //ako korisnik nije logiran onemoguci pristup
    		return redirect('/');
    	}

    	if($request->session()->get('role') != 'admin'){ //ako korisnik nije admin onemoguci pristup
    		return redirect('/');
    	}

		if($request->isMethod('get')){
			$query = DB::table('kategorija')->get()->toJson();
			$query = json_decode($query);
			return view('addProduct', ["kategorije" => $query]);
		}

	    $input=$request->all();
        $naziv = $input['ime'];
        $cijena = $input['cijena'];
        $dostupnost = $input['dostupnost'];
        $kategorija = $input['kategorija'];
        $opis = $input['opis'];

        $count = DB::table('products')->where('naziv', '=', $naziv)->count();
        if($count){ //proizvod je vec u bazi
    		$request->session()->flash('status', 'Došlo je do greške. Proizvod s tim imenom je već unesen!');
			$request->session()->flash('error', 1);
            return redirect('/adminPanel/addProduct');
        }

	    $query = DB::table('products')->insert(
	        ['naziv' => "$naziv", 'cijena' => "$cijena", 'dostupnost' => "$dostupnost", 'kategorija' => "$kategorija", 'opis' => "$opis"]
	    );
	    if(!$query){//proizvod nije unesen/greska
    		$request->session()->flash('status', 'Došlo je do greške. Proizvod nije unesen!');
			$request->session()->flash('error', 1);
            return redirect('/adminPanel/addProduct');	    	
	    }

        $query = DB::select('select * from products where naziv = ?', [$naziv]);
        $productID = $query[0]->id;
        $images=array();
        if($files=$request->file('slike')){
            foreach($files as $file){
                //$name=$file->getClientOriginalName();
                $random = substr(str_shuffle(MD5(microtime())), 0, 10);
                $extension = $file->getClientOriginalExtension();
                $randomName = $random.".".$extension;
                $file->move(public_path(), $randomName);

                $query = DB::table('slike')->insert(
                    ['productID' => "$productID", 'fileName' => "$randomName"]
                );
            }
        }else{
    		$request->session()->flash('status', 'Došlo je do greške. Problemi sa slikama!');
			$request->session()->flash('error', 1);
            return redirect('/adminPanel/addProduct');
        }

		$request->session()->flash('status', 'Proizvod uspješno dodan!');
		$request->session()->flash('error', 0);
		return redirect('/adminPanel/addProduct');

	}

	public function editProducts(Request $request){
    	if(!$request->session()->has('username')){ //ako korisnik nije logiran onemoguci pristup
    		return redirect('/');
    	}

    	if($request->session()->get('role') != 'admin'){ //ako korisnik nije admin onemoguci pristup
    		return redirect('/');
    	}

		if(!$request->isMethod('get')){
			return redirect("/");
		}
		return view('editProduct');
	}

	public function editProduct(Request $request){
    	if(!$request->session()->has('username')){ //ako korisnik nije logiran onemoguci pristup
    		return redirect('/');
    	}

    	if($request->session()->get('role') != 'admin'){ //ako korisnik nije admin onemoguci pristup
    		return redirect('/');
    	}

		if(!$request->isMethod('post')){
			return redirect("/");
		}

		$productID = $request->id;
        $query = DB::table('products')->where('id', $productID)
                ->update(['naziv' => $request->naziv, 'cijena' => $request->cijena, 'opis' => $request->opis, 'dostupnost' => $request->dostupnost, 'kategorija' => $request->kategorija]);

        if(!$query){
			$request->session()->flash('status', 'Došlo je do greške. Proizvod nije editiran!');
			$request->session()->flash('error', 1);
			return redirect('/adminPanel/editProducts');
        }

        $request->session()->flash('status', 'Proizvod uspješno editiran!');
		$request->session()->flash('tekst', $request->vrijednost);
		$request->session()->flash('error', 0);
		return redirect('/adminPanel/editProducts');
	}

	public function deleteProduct(Request $request){
    	if(!$request->session()->has('username')){ //ako korisnik nije logiran onemoguci pristup
    		return redirect('/');
    	}

    	if($request->session()->get('role') != 'admin'){ //ako korisnik nije admin onemoguci pristup
    		return redirect('/');
    	}

		if(!$request->isMethod('post')){
			return redirect("/");
		}

		$productID = $request->id;
		$query = DB::table('visits')->where('productID', $productID)->delete();
		$query = DB::table('wishlist')->where('productID', $productID)->delete();
		$query = DB::table('products')->delete($productID);
		if($query){
			$request->session()->flash('status', 'Proizvod uspješno izbrisan!');
			$request->session()->flash('tekst', $request->vrijednost);
			$request->session()->flash('error', 0);
			return redirect('/adminPanel/editProducts');			
		}

		$request->session()->flash('status', 'Došlo je do greške. Proizvod nije izbrisan!');
		$request->session()->flash('tekst', $request->vrijednost);
		$request->session()->flash('error', 1);
		return redirect('/adminPanel/editProducts');	
	}

	public function editKategorije(Request $request){
    	if(!$request->session()->has('username')){ //ako korisnik nije logiran onemoguci pristup
    		return redirect('/');
    	}

    	if($request->session()->get('role') != 'admin'){ //ako korisnik nije admin onemoguci pristup
    		return redirect('/');
    	}

		if($request->isMethod('get')){
			$kategorije = DB::select('select * from kategorija');
			return view('editKategorije', ['kategorije' => $kategorije]);
		}

		//nova kategorija PUT 
		if($request->_method == "PUT"){
            $query = DB::table('kategorija')->insert(['naziv' => "$request->naziv", 'komponenta' => "$request->komponenta"]);
			if(!$query){
				$request->session()->flash('status', 'Došlo je do greške. Kategorija nije kreirana!');
				$request->session()->flash('error', 1);
				return redirect('/adminPanel/editKategorije');
			}

			$request->session()->flash('status', 'Kategorija uspješno kreirana!');
			$request->session()->flash('error', 0);
			return redirect('/adminPanel/editKategorije');
		}

		//brisanje kategorije DELETE 
		if($request->_method == "DELETE"){
			$query = DB::table('kategorija')->delete($request->id);
			if(!$query){
				$request->session()->flash('status', 'Došlo je do greške. Kategorija nije izbrisana!');
				$request->session()->flash('error', 1);
				return redirect('/adminPanel/editKategorije');				
			}

			$request->session()->flash('status', 'Kategorija uspješno izbrisana!');
			$request->session()->flash('error', 0);
			return redirect('/adminPanel/editKategorije');
		}

		//update kategorije POST 
		if($request->_method == "POST"){
	        $query = DB::table('kategorija')->where('id',$request->id)
	                ->update(['naziv' => "$request->naziv"]);

			if($query){
				$request->session()->flash('status', 'Kategorija uspješno editirana!');
				$request->session()->flash('error', 0);
				return redirect('/adminPanel/editKategorije');
			}

			$request->session()->flash('status', 'Došlo je do greške. Kategorija nije editirana!');
			$request->session()->flash('error', 1);
			return redirect('/adminPanel/editKategorije');
		}	

	}

	public function posebneAkcije(Request $request){
    	if(!$request->session()->has('username')){ //ako korisnik nije logiran onemoguci pristup
    		return redirect('/');
    	}

    	if($request->session()->get('role') != 'admin'){ //ako korisnik nije admin onemoguci pristup
    		return redirect('/');
    	}

		if($request->isMethod('get')){
			$akcije = DB::table("posebneakcije")->get();
			$proizvodi = array();
			foreach($akcije as $akcija){
				$proizvodi[$akcija->productID] = DB::table("products")->where("id", $akcija->productID)->first();
			}

			return view('posebneAkcije', ['akcije' => $akcije, 'proizvodi' => $proizvodi]);
		}

		//nova akcija PUT 
		if($request->_method == "PUT"){
			$productID = $request->productID;
			$count = 0;
			$count = DB::table("products")->where("id", $productID)->count();
			if(!$count){ //ako takav proizvod ne postoji
				$request->session()->flash('status', 'Došlo je do greške. Proizvod za koji se pokušala napraviti akcija je nepostojeći!');
				$request->session()->flash('error', 1);
				return redirect('/adminPanel/posebneAkcije');				
			}

			$count = 0;
			$count = DB::table("posebneakcije")->where("productID", $productID)->count();
			if($count){ //ako je za taj proizvod vec napravljena posebna akcija
				$request->session()->flash('status', 'Došlo je do greške. Posebna akcija već postoji za taj proizvod!');
				$request->session()->flash('error', 1);
				return redirect('/adminPanel/posebneAkcije');				
			}

			//spremanje posebne akcije
	        if($file=$request->file('slika')){
                //$name=$file->getClientOriginalName();
                $random = substr(str_shuffle(MD5(microtime())), 0, 10);
                $extension = $file->getClientOriginalExtension();
                $randomName = $random.".".$extension;
                $file->move(public_path(), $randomName);

                $query = DB::table('posebneakcije')->insert(
                    ['productID' => "$productID", 'fileName' => "$randomName"]
                );
	        }else{
	    		$request->session()->flash('status', 'Došlo je do greške. Problemi sa slikom!');
				$request->session()->flash('error', 1);
	            return redirect('/adminPanel/posebneAkcije');       	
	        }

			$request->session()->flash('status', 'Posebna akcija uspješno dodana!');
			$request->session()->flash('error', 0);
			return redirect('/adminPanel/posebneAkcije');

		}

		//brisanje akcije DELETE
		if($request->_method == "DELETE"){
			$productID = $request->productID;
			$query = DB::table('posebneakcije')->where('productID', '=', $productID)->delete();
			if(!$query){//akcija nije izbrisana
				$request->session()->flash('status', 'Došlo je do greške. Akcija nije izbrisana!');
				$request->session()->flash('error', 1);
				return redirect('/adminPanel/posebneAkcije');				
			}

			$request->session()->flash('status', 'Posebna akcija uspješno izbrisana!');
			$request->session()->flash('error', 0);
			return redirect('/adminPanel/posebneAkcije');
		}

		//editiranje akcije POST
		if($request->_method == "POST"){
			$productID = $request->productID;
			$count = 0;
			$count = DB::table("products")->where("id", $productID)->count();
			if(!$count){ //ako takav proizvod ne postoji
				$request->session()->flash('status', 'Došlo je do greške. Proizvod za koji se pokušala urediti slika akcije je nepostojeći!');
				$request->session()->flash('error', 1);
				return redirect('/adminPanel/posebneAkcije');				
			}

			$count = 0;
			$count = DB::table("posebneakcije")->where("productID", $productID)->count();
			if(!$count){ //ako ne postoji posebna akcija za taj proizvod
				$request->session()->flash('status', 'Došlo je do greške. Posebna akcija ne postoji za taj proizvod!');
				$request->session()->flash('error', 1);
				return redirect('/adminPanel/posebneAkcije');				
			}


			//editiranje posebne akcije
	        if($file=$request->file('slika')){
                //$name=$file->getClientOriginalName();
                $random = substr(str_shuffle(MD5(microtime())), 0, 10);
                $extension = $file->getClientOriginalExtension();
                $randomName = $random.".".$extension;
                $file->move(public_path(), $randomName);

                $query = DB::table('posebneakcije')->where('productID', $productID)->update(['fileName' => "$randomName"]);
	        }else{
	    		$request->session()->flash('status', 'Došlo je do greške. Problemi sa slikom!');
				$request->session()->flash('error', 1);
	            return redirect('/adminPanel/posebneAkcije');       	
	        }

			$request->session()->flash('status', 'Posebna akcija uspješno editirana!');
			$request->session()->flash('error', 0);
			return redirect('/adminPanel/posebneAkcije');


		}



	}
}

?>