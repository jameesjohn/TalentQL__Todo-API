<?php

namespace App\Http\Controllers;

use App\Http\Resources\Todo as TodoResource;
use App\Http\Resources\TodoCollection;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    /**
     * Get all Todos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allTodos = Todo::all();
        return response(new TodoCollection($allTodos), Response::HTTP_OK);
    }

    /**
     * Store a newly created Todo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['body' => 'required']);

        $todo = new Todo;
        $todo->body = $request->get('body');
        $todo->save();

        return response(new TodoResource($todo), Response::HTTP_CREATED);
    }

    /**
     * Get a single Todo
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return response(new TodoResource($todo), Response::HTTP_OK);
    }

    /**
     * Update the specified Todo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'body' => 'required',
            'completed' => 'required|boolean'
        ]);

        $todo->body = $request->get('body');
        if (!$todo->isComplete()) {
            $todo->completed_at = (boolval($request->get('completed')) === true ? now() : null);
        }

        $todo->save();

        return response(new TodoResource($todo), Response::HTTP_OK);
    }

    /**
     * Remove the specified Todo.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->noContent();
    }
}
