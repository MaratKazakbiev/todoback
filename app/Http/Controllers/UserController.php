<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function CreateUser(Request $request){

        //'name', 'surname', 'city', 'email','password',

        //Производим валидацию данных
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'surname' => ['nullable', 'string', 'max:50'],
            'city'=>['required', 'string', 'max:50'],
            'email'=>['required', 'string', 'max:100', 'email', 'unique:users,email'],
            'password'=> ['required', 'string', 'min:7'],
        ]);

        //Выполняем преобразования
        $name = $validated['name'];
        $surname = $validated['surname'];
        $city = $validated['city'];
        $email = $validated['email'];
        $password = Hash::make($validated['password']);

        //Вызываем метод create модели User
        User::create(['name'=>$name,'surname'=>$surname,'city'=>$city,'email'=>$email,'password'=>$password]);

    }

    public function GetUser(Request $request){

        $id = $request->id;
        $user = User::where('id', $id)->find();

    }

    public function UpdateUser(Request $request){

        $id = $request->id;
        $field = $request->field;
        $value = $request->value;
        User::find($id)->update([$field => $value]);

    }

    public function DeleteUser(Request $request){

        $id = $request->id;

        User::find($id)->delete();

    }
}
