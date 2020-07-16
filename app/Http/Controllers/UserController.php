<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{

    public function checkCreds(Request $request)
    {
        $uri = $request->path();
        if (!$request->session()->has('username')){
            return redirect('/');
        }else{
            return redirect()->action('UserController@editProfil');
        }
    }

    public function register(Request $request)
    {

    	if($request->session()->has('username')){ //ako je korisnik vec logiran onemoguci pristup
    		return redirect('/editProfil');
    	}

		if($request->isMethod('get')){
			return view('register');
		}

        $ime = $request->ime;
        $prezime = $request->prezime;
        $username = $request->username;
        $email = $request->email;
        $password = $request->password;
        $telefon = $request->telefon;
        $adresa = $request->adresa;
        $pbroj = $request->pbroj;

        $count = 0;
        $count = DB::table('users')->where('email', '=', $email)->orWhere('username', '=', $username)->count();

        if($count){//vec postoji taj email ili username
            $request->session()->flash('status', 'Došlo je do greške. Korisničko ime ili email su već zauzeti!');
            $request->session()->flash('error', 1);
            return redirect('/register');            
        }

        $query = DB::table('users')->insert(
            ['ime' => "$ime", 'prezime' => "$prezime", 'email' => "$email", 'password' => "$password", 'username' => "$username", 'telefon' => "$telefon", 'adresa' => "$adresa", 'pbroj' => "$pbroj", 'role' => 'user']
        );

        if(!$query){
            $request->session()->flash('status', 'Došlo je do greške. Korisnik nije registriran!');
            $request->session()->flash('error', 1);
            return redirect('/register');             
        }

        //ako je sve u redu
        $request->session()->flash('status', 'Korisnik uspješno registriran. Sada se možete prijaviti!');
        $request->session()->flash('error', 0);
        return redirect('/login'); 

    }

    public function login(Request $request)
    {

    	if($request->session()->has('username')){ //ako je korisnik vec logiran onemoguci pristup
    		return redirect('/editProfil');
    	}

		if($request->isMethod('get')){
			return view('login');
		}

        if(!$request->has('username') || !$request->has('password')){
            return redirect('/login');
        }
        $username = $request->username;
        $password = $request->password;

        $count = 0;
        $count = DB::table('users')->where([['username', '=', $username], ['password', '=', $password]])->count();

        if(!$count){
            //return view('login', ['check' => 2]);
            $request->session()->flash('status', 'Došlo je do greške. Korisničko ime ili password nisu točni!');
            $request->session()->flash('error', 1);
            return redirect('/login');
        }else{
           $query = DB::select('select * from users where username = ?', [$username]);
           $query = (array)$query;
           
           $id = $query[0]->id;
           $role = $query[0]->role;
           $kosarica = array();
           $request->session()->put('id', $id);
           $request->session()->put('kosarica', $kosarica);
           $request->session()->put('username', $username);
           $request->session()->put('role', $role);

           if($role == "admin"){
            return redirect('/adminPanel');
           }

           return redirect('/editProfil');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

    public function editProfil(Request $request){

    	if(!$request->session()->has('username')){ //onemoguci pristup ako korisnik nije logiran
            return redirect('/');
        }

        $ime = $request->session()->get('username');
        $id = $request->session()->get('id');
        if ($request->isMethod('post')){
            $query = DB::table('users')->where('username', $ime)
                    ->update(['ime' => $request->ime, 'prezime' => $request->prezime, 'username' => $ime, 'email' => $request->email, 'password' => $request->password,
                              'telefon' => $request->telefon, 'adresa' => $request->adresa, 'pbroj' => $request->pbroj]);
            return redirect('/editProfil');
        }else{ //DIO ZA USERA
            $info = DB::table('users')->where('username', $ime)->first();
            $info = (array)$info;

            //DIO ZA WISHLIST
            $count = 0;
            $count = DB::table('wishlist')->where('userID', $id)->count();
            if(!$count){ //user nema nicega u wishlistu
                $info['wishlist'] = 0;
                //return view('editProfil', ['info' => $info]);
            }else{
	            $products = null;
	            $slike = null;
	            $i = 0;
	            $query = DB::select('select * from wishlist where userID = ?', [$id]);
	            foreach($query as $item){
	                $upit = DB::select('select * from products where id = ?', [$item->productID]);
	                //$products[$i++] = $upit[0];
	                $products[$i] = $upit[0];

	                //dohvacanje slike proizvoda
	                $upit = DB::table('slike')->where('productID', $item->productID)->first();
	                $slike[$i] = $upit;
	                $i++;
	            }
	            $info['wishlist'] = $products;
	            $info['slike'] = $slike;
            }


            //DIO ZA POVIJEST KUPOVINA
            $count = 0;
            $count = DB::table('kupovine')->where('userID', $id)->count();
            if(!$count){ //user nije nista kupio
                $info['kupovine'] = 0;
                return view('editProfil', ['info' => $info]);
            }

            $products = null;
            $slike = null;
            $kolicina = null;
            $komentar = null;
            $i = 0;
            $query = DB::select('select * from kupovine where userID = ?', [$id]);
            foreach($query as $item){
                $kolicina[$i] = $item->kolicina;
                $upit = DB::select('select * from products where id = ?', [$item->productID]);
                $products[$i] = $upit[0];

                //dohvacanje slike proizvoda
                $upit = DB::table('slike')->where('productID', $item->productID)->first();
                $slike[$i] = $upit;

                //provjera da li je user vec dodao komentar za odredjeni kupljeni proizvod
                $count = 0;
                $count = DB::table('komentari')->where([['userID', '=', $id], ['productID', '=', $item->productID]])->count();
                if($count){ //user je vec napisao komentar za taj proizvod
                    $komentar[$i] = 1;
                }else{
                    $komentar[$i] = 0;
                }
                $i++;
            }
            $info['kupovine'] = $products;
            $info['slikeKupovine'] = $slike;


            return view('editProfil', ['info' => $info, 'kolicina' => $kolicina, 'komentar' => $komentar]);
        }
    }

    public function addToWish(Request $request, $id){
        $userID = $request->session()->get('id');
        $productID = $id;

        $count = 0;
        $count = DB::table('wishlist')->where([['userID', '=', $userID], ['productID', '=', $productID]])->count();

        if($count){ //taj user je vec dodao isti proizvod u wishlist
            return redirect('/');
        }

        DB::table('wishlist')->insert(
            ['userID' => "$userID", 'productID' => "$productID"]
        );

        return redirect('/editProfil');
    }

    public function addToCart(Request $request, $id){

        if(!$request->session()->has('username')){ //onemoguci pristup ako korisnik nije logiran
            return redirect('/login');
        }

        $kosarica = $request->session()->get('kosarica');
        foreach($kosarica as $item){
            if($item['id'] == $id){ //ako je proizvod vec u kosarici
                return redirect('/cart');
            }
        }

        $proizvod = array();
        $proizvod['id'] = $id;
        $proizvod['kolicina'] = $request->kolicina;
        $proizvod['cijena'] = $request->cijena;

        $request->session()->push('kosarica', $proizvod);
        return redirect('/cart');
    }

    public function cart(Request $request){

        if(!$request->session()->has('username')){ //onemoguci pristup ako korisnik nije logiran
            return redirect('/');
        }

        $kosarica = $request->session()->get('kosarica');
        $i = 0;
        $info = array();
        $slike = array();
        foreach($kosarica as $key => &$item){ //dohvacanje podataka o proizvodima iz kosarice
            $count = 0;
            $count = DB::table("products")->where("id", $item['id'])->count();
            if(!$count){ //ako je proizvod iz kosarice u medjuvremenu izbrisan iz baze preskacemo ga i brisemo iz sesije
                unset($kosarica[$key]);
                $request->session()->put('kosarica', $kosarica);
                continue;
            }

            $query = DB::select('select * from products where id = ?', [$item['id']]);
            //$info[$i++] = $query;
            $info[$i] = $query;

            //dohvacanje slike proizvoda
            $query = DB::table('slike')->where('productID', $item['id'])->first();
            $slike[$i] = $query;

            $i++;
        }

        //dohvacanje podataka o korisniku
        $id = $request->session()->get('id');
        $query = DB::table('users')->where('id', $id)->first();

        return view('cart', ['info' => $info, 'userInfo' => $query, 'slike' => $slike]);
    }

    public function removeFromCart(Request $request, $id){

        $kosarica = $request->session()->get('kosarica');
        $i = 0;
        foreach($kosarica as $kos){
            if($kos['id'] == $id){
                unset($kosarica[$i]);
            }
            $i++;
        }

        $kosarica = array_values($kosarica);
        $request->session()->put('kosarica', $kosarica);
        return redirect('/cart');
    }

    public function updateKolicina(Request $request, $id){

        if(!$request->session()->has('username')){ //onemoguci pristup ako korisnik nije logiran
            return redirect('/');
        }

        $kosarica = $request->session()->get('kosarica');
        $novaKolicina = $request->kolicina;
        foreach($kosarica as &$item){
            if($item['id'] == $id){
                $item['kolicina'] = $novaKolicina;
            }
        }

        $request->session()->put('kosarica', $kosarica);
        return redirect('/cart');
    }

    public function blagajna(Request $request){
        /*echo $request->ime;
        echo $request->prezime;
        echo $request->email;
        echo $request->nacinpl;
        echo $request->telefon;
        echo $request->adresa;
        echo $request->pbroj;
        echo "<br>";*/
        if(!$request->session()->has('username')){ //onemoguci pristup ako korisnik nije logiran
            return redirect('/');
        }

        if ($request->isMethod('get')){
            return redirect("/");
        }

        $userID = $request->session()->get('id');
        $kosarica = $request->session()->get('kosarica');
        date_default_timezone_set('Europe/Zagreb');
        $date = date('Y-m-d H:i:s', time());

        //spremanje narudzbe u bazu
        foreach($kosarica as $item){
            $productID = $item['id'];
            $kolicina = $item['kolicina'];
            $cijenaKom = $item['cijena'];
            $cijenaTotal = floatval($cijenaKom * $kolicina);

            DB::table('kupovine')->insert(
                ['userID' => "$userID", 'productID' => "$productID", 'kolicina' => "$kolicina", 'vrijeme' => "$date", 'cijenaKom' => "$cijenaKom", 'cijenaTotal' => "$cijenaTotal"]
            );
        }
        
        //slanje emaila korisniku
        $to = "$request->email";
        $naslov = "Potvrda narudzbe";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <etrgovina@gmail.com>' . "\r\n";

        $emailPoruka = "
            <p>Hvala vam na kupovini!</p>
            <table>
              <tr>
                <th>Proizvod</th>
                <th>Kolicina</th>
                <th>Cijena</th>
              </tr>
        ";

        $cijenaTotal = 0;
        foreach($kosarica as $item){
          $productID = $item['id'];
          $kolicina = $item['kolicina'];
          $cijenaKom = $item['cijena'];
          $cijenaTotal += floatval($cijenaKom * $kolicina);
          $proizvod = DB::table('products')->find($productID);
          $naziv = $proizvod->naziv;

          $emailPoruka .= "
            <tr>
              <td>$naziv</td>
              <td>$kolicina</td>
              <td>$cijenaKom</td>
            </tr>
          ";
        }

        $emailPoruka .= "
          <tr>
            <td colspan='3'>
              Ukupno za platiti: $cijenaTotal
            </td>
          </tr>
          </table>
          <p>Vasi podaci: </p>
          $request->ime $request->prezime, $request->adresa, $request->pbroj <br>
          Broj telefona: $request->telefon <br>
          Nacin placanja: $request->nacinpl
        ";

        mail($to,$naslov,$emailPoruka,$headers);
        
        return view('blagajna', ['email' => $request->email]);
    }

    public function dodajKomentar(Request $request, $id){

        if(!$request->session()->has('username')){ //onemoguci pristup ako korisnik nije logiran
            return redirect('/');
        }

        $username = $request->session()->get('username');
        $userID = $request->session()->get('id');
        $productID = $id;
        $komentar = $request->komentar;
        $ocjena = $request->ocjena;

        DB::table('komentari')->insert(
            ['userID' => "$userID", 'productID' => "$productID", 'komentar' => "$komentar", 'ocjena' => "$ocjena", 'username' => "$username"]
        );

        return redirect('/editProfil');
    }

    public function resetPassword(Request $request){
        if ($request->isMethod('get')){
            return view('resetPassword', ["username" => '', "email" => '']);
        }

        if (!$request->isMethod('post')){
            return redirect("/login");
        }

        if($request->username == '' || $request->email == ''){
            return redirect("/login");
        }

        $count = DB::table('users')->where([['username', '=', $request->username], ['email', '=', $request->email]])->count();
        if(!$count){
            $request->session()->flash('status', 'Došlo je do greške. Ne postoji takva kombinacija korisnika i emaila');
            $request->session()->flash('error', 1);
            return redirect('/login');
        }

        $kod = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
        $query = DB::table('resetPassword')->insert(
            ['username' => "$request->username", 'email' => "$request->email", 'kod' => "$kod", 'iskoristen' => 0]);

        //slanje emaila korisniku
        $to = "$request->email";
        $naslov = "Kod za obnovu zaporke";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $emailPoruka = "Vaš kod za obnovu zaporke je: $kod";
        mail($to,$naslov,$emailPoruka,$headers);
        
        return view('resetPassword', ["username" => $request->username, "email" => $request->email]);
    }

    public function changePassword(Request $request){
        if (!$request->isMethod('post')){
            return redirect("/resetPassword");
        }

        if($request->kod == '' || $request->password == '' || $request->password2 == '' || $request->username == '' || $request->email == '' || $request->kod == ''){
            $request->session()->flash('status', 'Došlo je do greške. Sva polja moraju biti popunjena!');
            $request->session()->flash('error', 1);
            return redirect("/resetPassword");
        }

        if($request->password != $request->password2){
            $request->session()->flash('status', 'Došlo je do greške. Lozinke koje ste unijeli nisu iste!');
            $request->session()->flash('error', 1);
            return redirect("/resetPassword");
        }

        $count = DB::table('resetpassword')->where([['username', '=', $request->username], ['email', '=', $request->email], ['kod', '=', $request->kod], ['iskoristen', '=', 0]])->count();
        if(!$count){
            $request->session()->flash('status', 'Došlo je do greške. Kod je neispravan ili već iskorišten!');
            $request->session()->flash('error', 1);
            return redirect("/resetPassword");
        }

        $query = DB::table('resetpassword')->where([['username', '=', $request->username], ['email', '=', $request->email], ['kod', '=', $request->kod]])->update(['iskoristen' => 1]);
        if(!$query){
            $request->session()->flash('status', 'Došlo je do neočekivane greške!');
            $request->session()->flash('error', 1);
            return redirect("/resetPassword");            
        }

        $query = DB::table('users')->where([['username', '=', $request->username], ['email', '=', $request->email]])->update(['password' => $request->password]);
        if(!$query){
            $request->session()->flash('status', 'Došlo je do greške. Lozinka nije promijenjena!');
            $request->session()->flash('error', 1);
            return redirect("/resetPassword");
        }

        $request->session()->flash('status', 'Lozinka je promijenjena!');
        $request->session()->flash('error', 0);
        return redirect("/login");

    }

}

?>