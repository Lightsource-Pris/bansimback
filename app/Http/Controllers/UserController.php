<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Validator;
use App\Models\User;
use App\Models\Transactions;
use App\Http\Controllers\Responses;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [
            'index','Login',
        ]]);
        $this->responses = new Responses;
    }

    public function index()
    {
        return $this->responses->Four01('Unauthenticated');
    }

    public function Login(Request $request){

        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:8'
            ]);
    
            if ($validator->fails()) {
                return $this->responses->Four42("Some fields are missen or incorrect");
            }
    
            $jwt_token = null;
    
            if (!$jwt_token = Auth::guard('api')->attempt($request->only('email', 'password'))) {
                return $this->responses->Four01('Invalid login details');
            }
    
    
            return $this->responses->Two00([
                'status' => 200,
                'token' => $jwt_token,
            ],'Login successful');

        }catch(\Exception $e){
            return $this->responses->Five00($e);
        }
    }

    public function Logout(){
        try {
            auth()->logout();
            return $this->responses->Two00([], 'Logout Successful');
        } catch (\Exception $e) {
            return $this->responses->Five00($e);
        }
    }

    public function Transactions(){
        $trans = Transactions::where('user_id',auth()->user()->id)->get();

        return $this->responses->Two00($trans,'Transactions retrieved successfully');
    }

    public function profile(Request $request){
        try{
            $profile = User::where('id',auth()->user()->id)->first();
            return $this->responses->Two00($profile,'User retrieved successfully');
        }catch(\Exception $e){
            return $this->responses->Five00($e);
        }
    }

    public function TransferMoney(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'number' => 'required|string',
                'bank' => 'required|string',
                'sort_code' => 'required|string',
                'amount' => 'required|int',
                'pin' => 'required|int'
            ]);

            if ($validator->fails()) {
                return $this->responses->Four42("Some fields are missen or incorrect");
            }

            $user = User::where('account',$request->number)->where('sort_code',$request->sort_code)->first();
            if(!$user){
               return $this->responses->Four04('Oops! Recipient not found.');
            }
            if($user->id == auth()->user()->id){
                return $this->responses->Four00('Sorry you cannot send money to yourself');
            }
            if($user->pin != $request->pin){
                return $this->responses->Four00('Invalid pin');
            }

            $owner = auth()->user();

            if($request->amount > $owner->balance){
                return $this->responses->Four00('Insufficient balance');
            }

            $owner->balance-=$request->amount;
            $owner->save();
    
            $user->balance+=$request->amount;
            $user->save();

            return $this->responses->Two00([], 'Money sent successfully');
        }catch(\Exception $e){
            return $this->responses->Five00($e);
        }
    }


}
