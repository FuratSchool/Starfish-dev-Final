<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class TaskController
 * @package App\Http\Controllers\Admin
 */
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $tasks = Task::with(['users', 'groups'])->orderBy('deadline', 'asc')->get();
        $usertasks = auth()->user()->tasks()->with('assigner')->orderBy('deadline', 'asc')->get();
        $grouptasks = auth()->user()->groups->pluck('tasks')->collapse()->unique()->sortBy('deadline');
        $archivedtasks = Task::onlyTrashed()->get();
        return view("admin.tasks.index", compact('tasks', 'usertasks', 'grouptasks', 'archivedtasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $groups = Group::all();
        $users = User::all();
        return view('admin.tasks.create', compact('groups', 'users'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3',
            'description' => 'required',
            'type' => 'required',
            'deadline' => 'date',
            'assignee.*.type' => 'required|in:users,groups',
            'assignee.*.id' => 'required_with:assignee.*.type|numeric',
        ]);

        $title = $request->title;
        $description = $request->description;
        $type = $request->type;
        $status = 0;
        $assigner_id = auth()->id();
        $deadline = $request->deadline;

        $task = Task::create([
            'title' => $title,
            'description' => $description,
            'type' => $type,
            'status' => $status,
            'assigner_id' => $assigner_id,
            'deadline' => $deadline
          ]);

        $task->users()->attach($assigner_id);

        foreach ($request->assignees as $assignee) {
            $type = $assignee['type'];
            switch($type) {
                case 'users':
                    if($assigner_id == $assignee['id']) {
                        break;
                    }
                    $user = User::find($assignee['id']);
                    $user->tasks()->attach($task);
                    break;
                case 'groups':
                    $group = Group::find($assignee['id']);
                    $group->tasks()->attach($task);
                    break;
            }
        }
        activity('task-log')
            ->causedBy(auth()->user())
            ->performedOn($task)
            ->withProperties(['action' => 'created'])
            ->log('Taak:  '.$task->title.' aangemaakt door:'.auth()->user()->username);
        \Session::flash('success', "Taak aangemaakt!");

        return redirect()->route('admin.tasks.show', $task);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show(Task $task)
    {
        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function edit(Task $task)
    {
        $groups = Group::all();
        $users = User::all();
        return view("admin.tasks.edit", compact('task', 'groups', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return void
     */
    public function update(Request $request, Task $task)
    {
        $this->validate($request, [
            'title' => 'required|min:3',
            'description' => 'required',
            'type' => 'required',
            'deadline' => 'date',
            'assignee.*.type' => 'required|in:users,groups',
            'assignee.*.id' => 'required_with:assignee.*.type|numeric',
        ]);

        $task->title = $request->title;
        $task->description = $request->description;
        $task->type = $request->type;
        $task->deadline = $request->deadline;
        $task->save();
        $task->users()->detach();
        $task->groups()->detach();
        $task->users()->attach($task->assigner_id);
        foreach ($request->assignees as $assignee) {
            $type = $assignee['type'];
            switch($type) {
                case 'users':
                    $task->users()->attach($assignee['id']);
                    break;
                case 'groups':
                    $task->groups()->attach($assignee['id']);
                    break;
            }
        }
        activity('task-log')
            ->causedBy(auth()->user())
            ->performedOn($task)
            ->withProperties(['action' => 'updated'])
            ->log('Taak:  '.$task->title.' bewerkt door:'.auth()->user()->username);
        \Session::flash('success', "Taak aangepast");
        return redirect()->route('admin.tasks.show', $task);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return void
     * @throws \Exception
     */
    public function destroy(Task $task)
    {
        $task->delete();
        activity('task-log')
            ->causedBy(auth()->user())
            ->performedOn($task)
            ->withProperties(['action' => 'updated'])
            ->log('Taak:  '.$task->title.' gearchiveerd door:'.auth()->user()->username);
        \Session::flash('success', "Taak gearchiveerd");
        return redirect()->route('admin.tasks.index');
    }

    /**
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Task $task) {
        if(auth()->id() == $task->assigner_id or in_array(auth()->id(), $task->users()->get(['id'])->toArray()) or  in_array(auth()->id(), $task->groups()->users()->get(['id'])->toArray())) {
            if($task->status != 4) {
                $task->status++;
            } else {
                $task->status = 2;
            }
            $task->save();
            \Session::flash("success", "Status opgewaardeerd");
            return redirect()->back();
        } else {
            \Session::flash("error", "Onvoldoende rechten");
            return redirect()->back();
        }
    }

    /**
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finishTask(Task $task) {
        if(auth()->id() == $task->assigner_id or in_array(auth()->id(), $task->users()->get(['id'])->toArray()) or  in_array(auth()->id(), $task->groups()->users()->get(['id'])->toArray())) {
            $task->status++;
            $task->save();
            activity('task-log')
                ->causedBy(auth()->user())
                ->performedOn($task)
                ->withProperties(['action' => 'finished'])
                ->log('Taak:  '.$task->title.' afgerond door:'.auth()->user()->username);
            \Session::flash("success", "Taak afgerond");
            return redirect()->back();
        } else {
            \Session::flash("error", "Onvoldoende rechten");
            return redirect()->back();
        }
    }

    /**
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function needsRevision(Task $task) {
        $task->status = 4;
        $task->save();
        \Session::flash("success", "Status aangepast");
        return redirect()->back();
    }
}
