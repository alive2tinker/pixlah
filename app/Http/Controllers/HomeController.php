<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'screens' => Auth::user()->screens()->orderby('created_at','desc')->paginate(10),
            'messages' => Auth::user()->messages()->orderby('created_at','desc')->paginate(10),
            'attachments' => Auth::user()->attachments()->orderby('created_at','desc')->paginate(10),
            'widgets' => array()
        ]);
    }
}
