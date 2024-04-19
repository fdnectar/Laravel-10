<?php

namespace App\Http\Controllers;

use App\Models\User;
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
}
