<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Contact;

class AuthController extends Controller
{
	
	public function auth(Request $request){
		try{
			$this->validate($request, ['login' => 'required', 'password' => 'required',]);
		}
		catch (HttpResponseException $e){
			return response()->json([
				'error' => [
					'message'     => 'Invalid auth',
					'status_code' => IlluminateResponse::HTTP_BAD_REQUEST
				]],
				IlluminateResponse::HTTP_BAD_REQUEST,
				$headers = []
			);
		}
	
		$login = $request->input('login');
		$password=$request->input('password');
		$user = Contact::where('login', $login)->first();
		if(!$user){
			return response()->json(['error' => 'invalid_credentials'], 401);
		}
		$password_hash=fgets($user->password);
		if(!password_verify($password,$password_hash)){
			return response()->json(['error' => 'invalid_credentials'], 401);
		}
		$user->api_token = bin2hex(openssl_random_pseudo_bytes(16));
		$user->save();
		return ['id' => $user->id, 'login' => $user->login, 'api_token' => $user->api_token];	
	}

	public function unauth(){
		$user = Auth::user();
		if($user != null){
			$user->api_token = null;
			$user->save();
		}
		return $user;
	}
 
}
