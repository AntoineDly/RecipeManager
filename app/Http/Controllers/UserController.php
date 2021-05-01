<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController 
{
	
	/** 
	 * login api 
	 * 
	 * @return \Illuminate\Http\Response 
	 */ 
	public function login(){ 
		if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
			$user = Auth::user(); 
			$success['token'] =  $user->createToken('MyApp')-> accessToken; 
			return $this->sendResponse($success, 'User login successfully.');
		} 
		else{ 
			return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
		} 
	}

	/** 
	 * Register api 
	 * 
	 * @return \Illuminate\Http\Response 
	 */ 
	public function register(Request $request) 
	{
		$input = $request->all(); 

		$validator = Validator::make($input, [ 
			'name' => 'required', 
			'email' => 'required|email', 
			'password' => 'required', 
			'c_password' => 'required|same:password', 
		]);
		if ($validator->fails()) { 
			return $this->sendError('Validation Error.', $validator->errors());         
		}
		$input['password'] = bcrypt($input['password']); 
		$user = User::create($input); 
		$success['token'] =  $user->createToken('MyApp')-> accessToken; 
		$success['name'] =  $user->name;
		return $this->sendResponse($success, 'User register successfully.');
	}

}