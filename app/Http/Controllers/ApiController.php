<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;



class ApiController extends Controller
{
	public function getProductByString(Request $request, $string){
		$query = DB::table('products')
                ->where('naziv', 'like', "%$string%")
                ->get()->toJson();

        $data = null;
        $proizvodi = json_decode($query, true);
        if(empty($proizvodi)){ //ako nema rezultata
        	$data['status'] = 0;
        	print_r(json_encode($data));
        	die();
        }

        $data['status'] = 1;
        $i = 0;
        foreach($proizvodi as $proizvod){ //trazimo slike za nadjene proizvode
        	$data['proizvodi'][$i] = $proizvod;
        	$productID = $proizvod['id'];
			$query = DB::table('slike')
                ->where('productID', '=', "$productID")
                ->get()->toJson();

            $query = json_decode($query, true);
            $data['slike'][$i] = $query;
            $i++; 	
        }

        //dohvat kategorija
		$query = DB::table('kategorija')->get()->toJson();
		$data['kategorije'] = json_decode($query, true);
        print_r(json_encode($data));

	}

    public function checkKod(Request $request){
        if(!$request->isMethod('post')){
            $data['status'] = -1;
            print_r(json_encode($data));
            die();
        }

        if(!$request->has('username') || !$request->has('kod') || !$request->has('email')){
            $data['status'] = -1;
            print_r(json_encode($data));
            die();           
        }

        $count = DB::table('resetpassword')->where([['username', '=', $request->username], ['email', '=', $request->email], ['kod', '=', $request->kod], ['iskoristen', '=', 0]])->count();
        if(!$count){
            $data['status'] = 0;
            print_r(json_encode($data));
            die();            
        }

        /*$query = DB::table('resetpassword')->where([['username', '=', $request->username], ['email', '=', $request->email], ['kod', '=', $request->kod], ['iskoristen', '=', 0]])
                ->update(['iskoristen' => 1]);*/

        $data['status'] = 1;
        print_r(json_encode($data));
        die();      
    }
}