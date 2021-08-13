<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth ;
class AuthController extends Controller
{
    public function login(Request $request){
        $messages = [
            'email.required' => 'Địa chỉ email không được để trống',
            'email.email' => 'Địa chỉ email không hợp lệ',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => "Mật khẩu phải có ít nhất 6 ký tự",
            'password.max' => 'Mật khẩu không được quá 12 ký tự'
        ];
        $validator = Validator::make($request->only(['email','password']), [
            'password' => 'required|min:6|max:12',
            'email' => 'required|email',
        ], $messages);
        if($validator->fails()){
            return response()->json([
                'errors'=> $validator->errors(),
                'inputData'=>$request->only(['email','password'])
            ],422);
        }
        $credenttials = $request->only(['email','password']);
        if(!$token = JWTAuth::attempt($credenttials)){
            return response()->json(['success'=>false],401);
        }
        $user = User::select('id','name')->find(auth()->id());
        return response()->json(['success'=>true,'token'=>$token,'user'=>$user],200);
    }
    public function checkToken(){
        return response()->json(['success'=>true],200);
    }
    public function logout(){
        auth()->logout();
        return response()->json(['success'=>true],200);
    }
    public function userProfile(){
        return response()->json(["user"=>auth()->user()],200);
    }
    public function update(UpdateProfileRequest $request){
        $user = User::find(auth()->id());
        $user->update([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ]);
        auth()->logout();
        return response()->json(['success'=>true],200);
    }
}
