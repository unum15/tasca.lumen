<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Contact;
use App\LogIn;

class AuthController extends Controller
{
    
    public function auth(Request $request)
    {
        try{
            $this->validate($request, ['login' => 'required', 'password' => 'required',]);
        }
        catch (HttpResponseException $e){
            return response()->json(
                [
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
        if(!$user) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }
        $password_hash=fgets($user->password);
        if(!password_verify($password, $password_hash)) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }
        $bearer_token = bin2hex(openssl_random_pseudo_bytes(16));
        $user_agent = $request->header('user-agent');
        $host = $request->header('host');
        LogIn::create(
            [
            'contact_id' => $user->id,
            'bearer_token' => $bearer_token,
            'user_agent' => $user_agent,
            'host' => $host
            ]
        );
        $user_array = $this->getReturnUserData($user->id);
        $user_array['bearer_token'] = $bearer_token;
        return $user_array;
    }

    public function unauth(Request $request)
    {
        $user = Auth::user();
        if($user != null) {
            $bearer_token = $request->header('authorization');
            $bearer_token = preg_replace('/^Bearer\s*/', '', $bearer_token);
            LogIn::where('bearer_token', $bearer_token)->delete();
        }
        return ['status' => 'success'];
    }
    
    
    public function status(Request $request)
    {
        $user = Auth::user();
        if($user) {
            $user = $this->getReturnUserData($user->id);
            $user['status'] = 'active';
            return $user;
        }
        else{
            return ['status' => 'inactive'];
        }
    }
    
    
    private function getReturnUserData($id)
    {
        $user = Contact::select(
            [
            'id',
            'name',
            'login',
            'show_help',
            'show_maximium_activity_level_id',
            'default_service_window',
            'pending_days_out',
            'fluid_containers'
            ]
        )
            ->with('roles', 'roles.perms')
            ->findOrFail($id);
        return $user->toArray();
    }
 
}
