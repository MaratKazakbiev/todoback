<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Laravel\Sanctum\Sanctum;

class LoginController extends Controller
{
    public function login_user(Request $request){

        try{

            $request = request();

            $rules = [
                'email' => 'required|emal',
                'password' => 'required',
            ];

            $data = [
                'email' => $request->email,
                'password' =>  $request->password,
            ];

            dd($data);


            // if ($error = self::validation($data, $rules)){
            //     throw new Exception($error);
            // }

            if (Auth::attempt($data)) {

                $user = Auth::user();
                Auth::login($user);
                Sanctum::authenticate($user);
                return self::send_success();

            } else {
                return self:: send_error('Пароль или почта неверная');
            }

        }catch(Exception $error){

            return self::send_error($error->getMessage());

        }

    }
}
