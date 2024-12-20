<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

/**
 * Class LogsController
 * @package App\Http\Controllers\Admin
 */
class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {;
        $authlog = Activity::inLog('auth-log')->paginate('10', ['*'], 'auth');
        $userlog = Activity::inLog('user-log')->paginate('10', ['*'], 'users');
        $grouplog = Activity::inLog('group-log')->paginate('10', ['*'], 'groups');
        $tasklog = Activity::inLog('task-log')->paginate('10', ['*'], 'tasks');
        $specialistlog = Activity::inLog('spec-log')->paginate('10', ['*'], 'specialists');
        $specialismlog  = Activity::inLog('speci-log')->paginate('10', ['*'], 'specialisms');
        $therapylog  = Activity::inLog('ther-log')->paginate('10', ['*'], 'therapies');
        $complaintlog  = Activity::inLog('comp-log')->paginate('10', ['*'], 'complaints');
        return view("admin.logs.index", compact('authlog', 'userlog', 'grouplog', 'tasklog' ,'specialistlog', 'specialismlog', 'therapylog', 'complaintlog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
