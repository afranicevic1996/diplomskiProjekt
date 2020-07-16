<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;



class ProductsController extends Controller
{

    public function index(Request $request)
    {   
        //$kate = $request->input('kategorija');
        $input = request()->all();
        $kategorije = DB::table("kategorija")->get();
        $sort = 0;
        $tekstFilter = 0;
        $proizvodac = 0;
        $cijenaString = "";
        $sortString = "";
        $proizvodi = DB::table('products');
        $count = DB::table('products');

        // ----------------------------
        //DIO ZA IZLISTAVANJE SVIH PROIZVODA
        // ----------------------------
        if(!array_key_exists("kategorija", $input)){

            //ako je varijabla za limit cijene zadana
            if(isset($input['cijenaDo']) && $input['cijenaDo'] > 0){
                $cijenaDo = preg_replace("/[^0-9]/", "", $input['cijenaDo']);
                if(isset($input['cijenaOd'])){
                    $cijenaOd = preg_replace("/[^0-9]/", "", $input['cijenaOd']);
                }else{
                    $cijenaOd = 0;
                }

                if(isset($input['tekst'])){
                    $tekstClean = ProductsController::clean($input['tekst']);
                    $proizvodi = $proizvodi->where([['cijena', '>', $cijenaOd], ['cijena', '<', $cijenaDo], ['naziv', 'like', "%$tekstClean%"]]);
                    $count = $count->where([['cijena', '>', $cijenaOd], ['cijena', '<', $cijenaDo], ['naziv', 'like', "%$tekstClean%"]]);
                }else{
                    $proizvodi = $proizvodi->where([['cijena', '>', $cijenaOd], ['cijena', '<', $cijenaDo]]);
                    $count = $count->where([['cijena', '>', $cijenaOd], ['cijena', '<', $cijenaDo]]);
                }

            }else{
                if(isset($input['tekst'])){
                    $tekstClean = ProductsController::clean($input['tekst']);
                    $proizvodi = $proizvodi->where('naziv', 'like', "%$tekstClean%");
                    $count = $count->where('naziv', 'like', "%$tekstClean%");
                }                
            }
            //ako je sort varijabla zadana
            if(isset($input['sort'])){
                if($input['sort'] == 1){
                    //$query = DB::table('products')->orderBy("cijena", "asc")->paginate(5);
                    $sortString = "order by 'cijena' asc";
                    $proizvodi = $proizvodi->orderBy('cijena', 'asc');
                }elseif($input['sort'] == 2){
                    //$query = DB::table('products')->orderBy("cijena", "desc")->paginate(5);
                    $proizvodi = $proizvodi->orderBy('cijena', 'desc');
                }elseif($input['sort'] == 3){
                    //$query = DB::table('products')->orderBy("naziv", "asc")->paginate(5);
                    $proizvodi = $proizvodi->orderBy('naziv', 'asc');
                }elseif($input['sort'] == 4){
                    //$query = DB::table('products')->orderBy("naziv", "desc")->paginate(5);
                    $proizvodi = $proizvodi->orderBy('naziv', 'desc');
                }
            }

            //$query = DB::table('products')->selectRaw("* $cijenaString $sortString")->paginate(5);
            $query = $proizvodi->paginate(5);
            $proizvodi = DB::table('products')->get();
            $count = $count->count();
            foreach($proizvodi as $proizvod){
                $productID = $proizvod->id;
                $slike[$productID] = DB::table('slike')->where('productID', $productID)->first();
            }
            
            return view('products', ['kategorije' => $kategorije, 'proizvodi' => $query, 'trenutnaKate' => 0, 'slike' => $slike, 'count' => $count]);
        }


        // ----------------------------
        //DIO ZA POSTAVLJENU KATEGORIJU
        // ----------------------------
        $kate = preg_replace("/[^0-9]/", "", $input['kategorija']);
        $proizvodi = DB::table('products');
        $count = DB::table('products');

        //ako je varijabla za limit cijene zadana
        if(isset($input['cijenaDo']) && $input['cijenaDo'] > 0){
            $cijenaDo = preg_replace("/[^0-9]/", "", $input['cijenaDo']);
            if(isset($input['cijenaOd'])){
                $cijenaOd = preg_replace("/[^0-9]/", "", $input['cijenaOd']);
            }else{
                $cijenaOd = 0;
            }

            if(isset($input['tekst'])){
                $tekstClean = ProductsController::clean($input['tekst']);
                $proizvodi = $proizvodi->where([['kategorija', '=', $kate], ['cijena', '>', $cijenaOd], ['cijena', '<', $cijenaDo], ['naziv', 'like', "%$tekstClean%"]]);
                $count = $count->where([['kategorija', '=', $kate], ['cijena', '>', $cijenaOd], ['cijena', '<', $cijenaDo], ['naziv', 'like', "%$tekstClean%"]]);
            }else{
                $proizvodi = $proizvodi->where([['kategorija', '=', $kate], ['cijena', '>', $cijenaOd], ['cijena', '<', $cijenaDo]]);
                $count = $count->where([['kategorija', '=', $kate], ['cijena', '>', $cijenaOd], ['cijena', '<', $cijenaDo]]);
            }

        }else{
            if(isset($input['tekst'])){
                $tekstClean = ProductsController::clean($input['tekst']);
                $proizvodi = $proizvodi->where([['kategorija', '=', $kate], ['naziv', 'like', "%$tekstClean%"]]);
                $count = $count->where([['kategorija', '=', $kate], ['naziv', 'like', "%$tekstClean%"]]);
            }else{
                $proizvodi = $proizvodi->where('kategorija', $kate);
                $count = $count->where('kategorija', $kate);
            }                
        }

        //ako je sort varijabla zadana
        if(isset($input['sort'])){
            if($input['sort'] == 1){
                //$query = DB::table('products')->orderBy("cijena", "asc")->paginate(5);
                $sortString = "order by 'cijena' asc";
                $proizvodi = $proizvodi->orderBy('cijena', 'asc');
            }elseif($input['sort'] == 2){
                //$query = DB::table('products')->orderBy("cijena", "desc")->paginate(5);
                $proizvodi = $proizvodi->orderBy('cijena', 'desc');
            }elseif($input['sort'] == 3){
                //$query = DB::table('products')->orderBy("naziv", "asc")->paginate(5);
                $proizvodi = $proizvodi->orderBy('naziv', 'asc');
            }elseif($input['sort'] == 4){
                //$query = DB::table('products')->orderBy("naziv", "desc")->paginate(5);
                $proizvodi = $proizvodi->orderBy('naziv', 'desc');
            }
        }

        $query = $proizvodi->paginate(5);
        $proizvodi = DB::table('products')->where('kategorija', $kate)->get();
        $count = $count->count();
        $slike = null;
        foreach($proizvodi as $proizvod){
            $productID = $proizvod->id;
            $slike[$productID] = DB::table('slike')->where('productID', $productID)->first();
        }

        return view('products', ['kategorije' => $kategorije, 'proizvodi' => $query, 'trenutnaKate' => $kate, 'slike' => $slike, 'count' => $count]);
    }

    public function getProduct(Request $request, $id)
    {
         $query = DB::table('products')->find($id);
         if($query === null){ //ako nije nadjen proizvod sa tim id
           	return redirect('/');
		}
        $info = (array)$query;

        //DIO ZA BROJAC KLIKOVA
        $count = 0;
        $count = DB::table('visits')->where('productID', $id)->count();
        if(!$count){//ako ne postoji u bazi dodajemo novi zapis
            $query = DB::table('visits')->insert(['productID' => "$id", 'clicks' => "1"]);
        }else{
            $brojacKlikova = DB::table('visits')->where('productID', $id)->first();
            $brojacKlikova = $brojacKlikova->clicks + 1;
            $query = DB::table('visits')->where('productID', $id)
                    ->update(['clicks' => "$brojacKlikova"]);
        }

        $count = 0;
        $count = DB::table('slike')->where('productID', $id)->count();
        if(!$count){ //ako ne postoje slike za ovaj proizvod
            $info['slike'] = 0;
        }else{
            $slike = DB::select('select * from slike where productID = ?', [$id]);
            $info['slike'] = $slike;
        }

        //DIO ZA KOMENTARE
        $count = 0;
        $count = DB::table('komentari')->where('productID', $id)->count();
        if(!$count){ //ako ne postoje komentari za ovaj proizvod
            $info["komentari"] = 0;
        }else{
            $query = DB::select('select * from komentari where productID = ?', [$id]);
            $info["komentari"] = $query;
        }

        //DIO ZA WISHLIST
        if($request->session()->has('username')){ //ako je korisnik logiran radimo provjeru da li je proizvod vec u wishlistu
            $userID = $request->session()->get('id');
            $count = 0;
            $count = DB::table('wishlist')->where([['userID', '=', $userID], ['productID', '=', $id]])->count();
            if(!$count){ //ako user nema taj proizvod u wishlistu
                $info['wishlistCheck'] = 0;
                return view('product', ['info' => $info]);
            }

            $info['wishlistCheck'] = 1;
            return view('product', ['info' => $info]);
        }
        
        return view('product', ['info' => $info]);
    }

    public function deleteWish(Request $request, $id){
        if(!$request->session()->has('username')){ //onemoguci pristup ako korisnik nije logiran
            return redirect('/');
        }

        $userID = $request->session()->get('id');
        $count = 0;
        $count = DB::table('wishlist')->where([['userID', '=', $userID], ['productID', '=', $id]])->count();
        if(!$count){ //trazeni proizvod nije u wishlistu
            return redirect('/');
        }

        DB::table('wishlist')->where([['userID', '=', $userID], ['productID', '=', $id]])->delete();
        return redirect('/editProfil');
    }

    public static function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

}

?>