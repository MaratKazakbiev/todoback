<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class GetTodo extends Controller
{
    public function __invoke(Request $request)
    {
        $todos = Todo::where('user_id', 1)->get();
        return $todos->toJson();
    }
}
