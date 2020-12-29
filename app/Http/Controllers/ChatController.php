<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chat()
    {
        return view('chat');
    }
    public function send(Request $request)
    {
        $user=Auth::user();
        event(new ChatEvent($request->message,$user));
        $this->saveToSession($request);
        return $request->all();
    }
    public function saveToSession(Request $request)
    {
        session()->put('chat',$request->chat);
    }
    public function getOldMessages()
    {
        return session('chat');
    }
    public function deleteSession(Request $request)
    {

        $request->session()->forget('chat');
    }

}
