<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Todo;
use Illuminate\Support\Str;
use Exception;

class TodoController extends Controller
{

    public function create_todo(Request $request){

        try{

            $validated = $request->validate([
                'title' => ['required', 'string'],
                'user_id' => ['required'],
            ]);

            $user_id = $validated['user_id'];
            $user = User::where('user_id', $user_id)->get();
            if (!$user){

                throw new Exception('Пользователь не найден');
            }

            $data = [
                'title' => $validated['title'],
                'user_id' => $validated['user_id'],
            ];

            Todo::create($data);
            return self::send_success();

        }catch(Exception $error){

            return self::send_error($error->getMessage());

        }
    }

    public function get_todos(Request $request){

        try{

            $user_id = $request->validate([
                'user_id' => ['required'],
            ]);

            $user = User::where('user_id', $user_id)->get();
            if (!$user){
                throw new Exception('Пользователь не найден');
            }

            $todos = Todo::where('user_id', $user_id)->get();
            return self::send_success();

        }catch(Exception $error){

            return self::send_error($error->getMessage());

        }

    }

    public function update_todo(Request $request){

        try{

            $validated = $request->validate([
                'user_id' => ['required'],
                'todo_id' => ['required'],
            ]);

            $user_id = $validated['user_id'];
            $todo_id = $validated['todo_id'];

            $user = User::where('user_id', $user_id)->get();
            if (!$user){
                throw new Exception('Пользователь не найден');
            }

            $todo = Todo::where('todo_id', $todo_id)->get()->first();

            if ($todo->is_active === true){

                $todo->is_active = false;
                $todo->save();

            }else{

                $todo->is_active = true;
                $todo->save();

            }

            return self::send_success();

        }catch(Exception $error){

            return self::send_error($error->getMessage());

        }

    }

    public function delete_todo(Request $request){

        try{

            $validated = $request->validate([
                'user_id' => ['required'],
                'todo_id' => ['required'],
            ]);

            $user_id = $validated['user_id'];
            $todo_id = $validated['todo_id'];

            $user = User::where('user_id', $user_id)->get();
            if (!$user){
                throw new Exception('Пользователь не найден');
            }

            $todo = Todo::where('todo_id', $todo_id)->get()->first()->delete();

            return self::send_success();

        }catch(Exception $error){

            return self::send_error($error->getMessage());

        }

    }

    public function delete_todos(Request $request){

        try{

            $user_id = $request->validate(['user_id' => ['required']]);

            $user = User::where('user_id', $user_id)->get();
            if (!$user){
                throw new Exception('Пользователь не найден');
            }

            $todos = Todo::where('user_id', $user_id)->get();

            if ($todos->count() > 0){
                foreach ($todos as $todo){
                    $todo->delete();
                }
            }

        }catch(Exception $error){

            return self::send_error($error->getMessage());

        }

    }
}
