<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Message;
use App\Models\Screen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $screens = Auth::user()->screens()->where('title', 'LIKE', '%' . $request->input('keyword') . '%')->orderby('created_at','desc')->paginate(10);
        $attachments = Auth::user()->attachments()->where('title', 'LIKE', '%' . $request->input('keyword') . '%')->orderby('created_at','desc')->paginate(10);
        $messages = Auth::user()->messages()->where('text', 'LIKE', '%' . $request->input('keyword') . '%')->orderby('created_at','desc')->paginate(10);

        return view('search', [
            'screens' => $screens,
            'attachments' => $attachments,
            'messages' => $messages
        ]);
    }
}
