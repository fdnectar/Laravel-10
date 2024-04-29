<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessengerController extends Controller
{
    public function index ()
    {
        return view('messenger.index');
    }

    public function searchUser(Request $request) {
        $getRecords = null;

        $input = $request['query'];
        $records = User::where('id', '!=', Auth::user()->id)
            ->where('name', 'LIKE', "%{$input}%")
            ->orWhere('username', 'LIKE', "%{$input}%")
            ->paginate(10);

        if($records->total() < 1) {
            $getRecords = "<p class='text-center mt-3'>No User Found...</p>";
        }

        foreach($records as $record) {
            $getRecords .= view('messenger.components.search_item', compact('record'))->render();
        }

        return response()->json([
            'records' => $getRecords,
            'last_page' => $records->lastPage()
        ]);
    }

    public function fetchIdInfo(Request $request) {
        $user = User::where('id', $request['id'])->first();
        return response()->json([
            'user' => $user
        ]);
    }

    public function sendMessage(Request $request) {
        $request->validate([
            'message' => 'required',
            'id' => 'required|integer',
            'temporaryMsgId' => 'required'
        ]);

        $message = new Message();
        $message->from_id = Auth::user()->id;
        $message->to_id = $request->id;
        $message->body = $request->message;
        $message->save();

        return response()->json([
            'message' => $this->messageCard($message),
            'tempID' => $request->temporaryMsgId
        ]);
    }

    public function messageCard($message) {
        return view('messenger.components.message-card', compact('message'))->render();
    }
}
