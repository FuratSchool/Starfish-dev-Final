<?php

namespace App\Http\Controllers\Admin;

use App\Models\Group;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

/**
 * Class MessageController
 * @package App\Http\Controllers\Admin
 */
class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $usermessages = auth()->user()->messages()->with('sender')->latest()->get();
        $groupmessages = auth()->user()->groups->pluck('messages')->collapse()->unique();
        $sentmessages = auth()->user()->sent()->withTrashed()->latest()->get();
        $tasks = auth()->user()->tasks()->orderBy('deadline', 'asc')->get();
        $grouptasks = auth()->user()->groups->pluck('tasks')->collapse()->unique()->sortBy('deadline');
        return view('admin.messages.index', compact('usermessages', 'groupmessages', 'sentmessages', 'tasks', 'grouptasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create($type = null, $id = null, $subject = null)
    {
        if ($subject) {
            $subject = Crypt::decryptString($subject);
        }
        $groups = Group::all();
        $users = User::all();
        return view('admin.messages.create', compact('groups', 'users', 'type', 'id', 'subject'));
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
            'subject' => 'required|min:3',
            'body' => 'required',
            'recipients.*.type' => 'required|in:users,groups',
            'recipients.*.name' => 'required_with:recipients.*.type|numeric',
        ]);
        $subject = $request->subject;
        $body = $request->body;
        $sender_id = auth()->id();
        $read = 0;
        $message = Message::create([
            'subject' => Crypt::encryptString($subject),
            'body' => Crypt::encryptString($body),
            'sender_id' => $sender_id,
            'read' => $read
        ]);

        foreach ($request->recipients as $recipient) {
            $type = $recipient['type'];
            switch($type) {
                case 'users':
                    $user = User::find($recipient['name']);
                    $user->messages()->attach($message);
                    break;
                case 'groups':
                    $group = Group::find($recipient['name']);
                    $group->messages()->attach($message);
                    break;
            }
        }
        \Session::flash('success', "Bericht verstuurd!");

        return redirect()->route('admin.messages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message $message
     * @return void
     */
    public function show(Message $message)
    {
        return view('admin.messages.show', compact('message'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message $message
     * @return void
     * @throws \Exception
     */
    public function destroy(Message $message)
    {
        $msg = Message::find($message->id);
        $msg->delete();
        \Session::flash('success', "Bericht verwijderd");
        return redirect()->route('admin.messages.index');
    }

    /**
     * @param Message $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function archive(Message $message) {
        $msg = Message::find($message->id);
        auth()->user()->messages()->detach($msg);
        \Session::flash('success', "Bericht gearchiveerd");
        return redirect()->route('admin.messages.index');
    }

    /**
     * @param Message $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Message $message) {
        $message->restore();
        \Session::flash('success', "Bericht hersteld");
        return redirect()->route('admin.messages.index');
    }
}
