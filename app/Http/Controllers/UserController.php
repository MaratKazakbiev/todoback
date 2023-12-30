<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Todo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;

class UserController extends Controller
{
    public function create_user(Request $request){

        try{

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:50'],
                'surname' => ['nullable', 'string', 'max:50'],
                'city'=>['required', 'string', 'max:50'],
                'email'=>['required', 'string', 'max:100', 'email', 'unique:users,email'],
                'password'=> ['required', 'string', 'min:7'],
            ]);

            $data = [

                'name' => $validated['name'],
                'surname' => $validated['surname'],
                'city' => $validated['city'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),

            ];

            User::create($data);

            return self::send_success();

        }catch(Exception $error){

            return self::send_error($error->getMessage());

        }


    }

    public function get_user(Request $request){

        try{
            $id = $request->id;
            $user = User::where('user_id', $id)->get()->first();
            return self::send_success([
                'data' => $user,
            ]);

        }catch(Exception $error){
            return self::send_error($error->getMessage());
        };


    }

    public function update_user(Request $request){

        $user_id = $request->user_id;

        try{

            $validated = $request->validate([
                'name' => ['nullable', 'string', 'max:50'],
                'surname' => ['nullable', 'string', 'max:50'],
                'city'=>['nullable', 'string', 'max:50'],
            ]);

            $data = [

                'name' => $validated['name'],
                'surname' => $validated['surname'],
                'city' => $validated['city'],

            ];

            User::where('user_id', $user_id)->get()->first()->update($data);
            return self::send_success();

        }catch(Exception $error){
            return self::send_error($error->getMessage());
        };



    }

    public function delete_user(Request $request){

        $user_id = $request->user_id;

        try{

            $todos = Todo::where('user_id', $user_id)->get();

            if ($todos->count() > 0){
                foreach ($todos as $todo){
                    $todo->delete();
                }
            }

            User::find($user_id)->delete();
            return self::send_success();

        }catch(Exception $error){
            return self::send_error($error->getMessage());
        };

    }
}
