<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthenticatePostRequest;
use App\Http\Requests\UserStorePostRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {

        $credentials = $request->only('email', 'password');

        try {

            if (! $token = JWTAuth::attempt($credentials)) {

                return response()->json(["success" => false,"message" => "Invalid Credentials"],400);

            }
        } catch (JWTException $e) {

            Log::error($e);

            return response()->json(["success" => false,"message" => "Could not create token"],500);


        }

        return response()->json(["success" => true,"message" => "Authenticated User", "token"=>$token]);

    }
    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {

                    return response()->json(["success" => false,"message" => "User not found"],404);

            }
            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                Log::error($e->getStatusCode());
                
                return response()->json(["success" => false,"message" => "Token expired"]);

            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                Log::error($e->getStatusCode());
                
                return response()->json(["success" => false,"message" => "Token invalid"]);

            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                    Log::error($e->getStatusCode());
                
                    return response()->json(["success" => false,"message" => "Token Absent"]);

            }

            return response()->json(["success" => true,"message" => "Successfully Obtained Data", "user"=>$user],200);

    }

    public function register(Request $request)
    {
        
        try{

            DB::beginTransaction();
    
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            $token = JWTAuth::fromUser($user);

            DB::commit();

            return response()->json(["success" => true,"message" => "User registered successfully", "user"=>$user,"token"=>$token], 201);

        }catch(\Exception $e){

            DB::rollBack();

            Log::error($e);

            return response()->json(["success" => false, "message" => "There was an error when registering"], 200);

        }
    }
}
