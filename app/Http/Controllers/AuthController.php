<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function init(){
		$user = Auth::User();			
    	return response()->json(['user'=>$user], 200);
    }

    public function login(Request $request){
		// dd(Auth::attempt(['email'=>$request->email, 'password'=>$request->password]));
    	if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password], true)) {							
    		return response()->json(['user'=>Auth::User()], 200);
    	}else{
    		return response()->json(['error'=>'Could Not log you in.'], 401);
    	}
    }

    public function register(Request $request){
    	$user = User::where('email',$request->email)->first();

    	if (isset($user->id)) {
    		return response()->json(['error'=>'Email Already Exists.'], 401);
    	}
    	$user = new User();

    	$user->name = $request->name;
    	$user->email = $request->email;
		$user->password = Hash::make($request->password);
		$user->ch_pass = base64_encode($request->password);
    	$user->save();

    	Auth::login($user);

    	return response()->json($user, 200); 
    }

    public function logout(){

    	Auth::logout();
    }

    public function profile($id){
        $user = User::where('id','=',$id)->first();
        return response()->json($user, 200);
	}
	public function changepassword(Request $request){
		$email = Auth::User()->email;
		$id = Auth::User()->id;
		if (Auth::attempt(['email'=>$email,'password'=>$request->password], true)) {
			$data['password'] = Hash::make($request->newpassword);
			$data['ch_pass'] = base64_encode($request->newpassword);
			$user = User::where('id','=',$id)->update($data);
    		return response()->json(['user'=>Auth::User()], 200);
    	}else{
    		return response()->json(['error'=>'Could Not log you in.'], 401);
    	}
        
	}
}
