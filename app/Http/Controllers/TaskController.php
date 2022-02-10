<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $data = [];
        $tasks = Task::all();

        foreach($tasks as $task)
        {
            $data[] = [
                'task_name' => $task->task_name,
                'task_date' => Carbon::parse($task->task_date)->timezone(session('timezone'))->format('g a, jS \o\f F'),
                'description' => $task->description
            ];
        }
        
        return view('welcome',[ 'tasks' => $data ] );
    }

    public function createTask(Request $request)
    {
        $this->validate($request,[
            'task_name' => 'required',
            'description' => 'required',
            'task_date' => 'required'
        ]);

        session(['timezone' => $request->timezone]); 

        Task::create([
            'task_name' => $request->task_name,
            'description' => $request->description,
            'task_date' => $request->task_date
        ]);

        return back()->withInput();
    }
}
