<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Requests\RegisterRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthSupplierController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $req_data = $request->only([
                'name',
                'email',
                'password'
            ]);
            $data = new Supplier($req_data);
            $data->save();

            return $data;
        }catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'log'=>$e->getMessage()
            ],500);
        }
    }
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = auth('supplier')->attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'Some Error Message'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }
        $user = auth('supplier')->user();
        return $this->respondWithToken($user,$token);
    }
    protected function respondWithToken($user,$token)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'user'=>$user,
                'access_token' => $token,
                'token_type' => 'bearer',
            ]
        ], 200);
    }
    public function logout(){
        if (auth('supplier')->user()) {
            auth()->logout();
        }

        return response()->json([
            'status'=>true,
            'message'=>'Logout Successfully'
        ],200);
    }
}
