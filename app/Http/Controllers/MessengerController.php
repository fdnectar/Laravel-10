<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;

class MessengerController extends Controller
{
    use FileUploadTrait;

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
            // 'message' => 'required',
            'id' => 'required|integer',
            'temporaryMsgId' => 'required',
            'attachment' => 'nullable|max:1024|image'
        ]);

        $attachment = $this->uploadFIle($request, 'attachment');
        $message = new Message();
        $message->from_id = Auth::user()->id;
        $message->to_id = $request->id;
        $message->body = $request->message;
        if($attachment) $message->attachment = json_encode($attachment);
        $message->save();

        return response()->json([
            // 'message' => $this->messageCard($message),
            'message' => $message->attachment ? $this->messageCard($message, true) : $this->messageCard($message),
            'tempID' => $request->temporaryMsgId
        ]);
    }

    public function messageCard($message, $attachment = false) {
        return view('messenger.components.message-card', compact('message', 'attachment'))->render();
    }
}
