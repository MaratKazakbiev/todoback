<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{

    //Создаем задачу
    public function CreateTodo(Request $request){

        $validate = validator(['title' => $request->title],['title' => ['required', 'string']]);
        $title = $validate->validate()['title'];
        $id = $request->id;

        if ($title && $id) {

            Todo::create(['title' => $title, 'user_id' => $id]);

        }else{

            $error = 'Ошибка ввода';
            return response()->json($error);

        }

    }

    //Получаем все задачи пользователя
    public function GetTodos(Request $request){

        $id = $request->id;

        $todos = Todo::where('user_id', $id);

        return response()->json($todos);

    }

    //Обновляем статус задачи
    public function UpdateTodo(Request $request){

        $id = $request->id;

        $todo = Todo::find($id);
        $todo->isActive = !($todo->isActive);
        $todo->save();


    }

    //Удаляем определенную задачу пользователя
    public function DeleteTodo(Request $request){

        $id = $request->id;

        Todo:where('id', $id)->delete();

    }

    //Удаляем все задачи пользователя
    public function DeleteTodos(Request $request){

        $id = $request->id;

        Todo:where('user_id', $id)->delete();

    }
}
