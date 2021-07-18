<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;

class TaskController extends Controller
{
    /**
     * タスク一覧
     * @param Folder $folder
     * @return \Illuminate\View\View
     */
    public function index(Folder $folder)
    {
        $folders = Auth::user()->folders()->get();

        //$tasks = Task::where('folder_id', $current_folder->id)->get();
        $tasks = $folder->tasks()->get();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks,
        ]);
    }

    /**
     * GET /folders/{id}/tasks/create
     * 
     * タスク作成フォーム
     * @param Folder $folder
     * @return \Illuminate\View\View
     *
     */
    public function showCreateForm(Folder $folder)
    {
        return view('tasks/create',[
            'folder_id' => $folder->id
        ]);
    }

     /**
     * タスク作成
     * @param Folder $folder
     * @param CreateTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Folder $folder, CreateTask $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;
    
        $folder->tasks()->save($task);
    
        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }
    
    /**
     * GET /folders/{id}/tasks/{task_id}/edit
     * 
     * タスク編集フォーム
     * @param Folder $folder
     * @param Task $task
     * @return \Illuminate\View\View
     */
    public function showEditForm(Folder $folder, Task $task)
    {
        $this->checkRelation($folder, $task);
        return view('tasks/edit',[
            'task' => $task,
        ]);
    }

    /**
     * タスク編集
     * @param Folder $folder
     * @param Task $task
     * @param EditTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Folder $folder, Task $task, EditTask $request)
    {
        $this->checkRelation($folder,$task);
        $task = Task::find($task_id);

        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index',[
            'id' => $task->folder_id,
        ]);
    }

}